<?php

namespace App\Http\Controllers\Front\Payment;

use Alert;
use App\Models\Delivery;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;

/**
 * Class PortmanatController
 *
 * @package App\Http\Controllers\Front\Payment
 */
class PortmanatController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        if (! empty($_GET['psp_rrn'])) {
            $psp_rrn = request()->get('psp_rrn');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://psp.mps.az/check");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['psp_rrn' => $psp_rrn]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($server_output, true);

            if (! is_array($obj)) {
                return null;
            }
            $packageId = request()->get('client_rrn');

            $exploded = explode("_", $packageId);

            $id = $exploded[0];

            if (! isset($exploded[1]) || (isset($exploded[1]) && $exploded[1] != 'c')) {


                $package = Package::find($id);

                if ($package && ! $package->paid) {

                    if ($obj['code'] == '1') {
                        // Pending
                        return redirect()->to(route('my-packages', ['id' => 2]) . '?pending=true');
                    } elseif ($obj['code'] == '0') {
                        // Success
                        Transaction::create([
                            'user_id'    => $package->user_id,
                            'custom_id'  => $package->id,
                            'paid_by'    => 'PORTMANAT',
                            'amount'     => $package->delivery_manat_price,
                            'type'       => 'OUT',
                            'paid_for'   => 'PACKAGE',
                            'note'       => $package->id . ' id-li bağlamaya görə ödəmə',
                            'extra_data' => json_encode($obj),
                        ]);

                        /* make paid */
                        $package->paid = true;
                        $package->save();

                        /* Send notification */
                        $message = null;
                        $message .= "💳 <b>" . $package->user->full_name . "</b> (" . $package->user->customer_id . ") ";
                        $message .= "Portmanat ilə <a href='http://panel." . env('DOMAIN_NAME') . "/packages/" . $package->id . "/edit'>" . $package->tracking_code . "</a> tracking kodu olan bağlaması üçün <b>" . $package->delivery_manat_price . " AZN</b> ödəniş etdi.";

                        sendTGMessage($message);

                        return redirect()->to(route('my-packages', ['id' => 2]) . '?success=true');
                    } else {
                        // Error
                        Transaction::create([
                            'user_id'    => $package->user_id,
                            'custom_id'  => $package->id,
                            'paid_by'    => 'PORTMANAT',
                            'amount'     => null,
                            'type'       => 'ERROR',
                            'paid_for'   => 'PACKAGE',
                            'extra_data' => json_encode($obj),
                        ]);

                        $error = isset($obj['description']) ? $obj['description'] : 'Payment Error';

                        return redirect()->to(route('my-packages', ['id' => 2]) . '?error=' . $error);
                    }
                }
            } elseif (isset($exploded[1]) && $exploded[1] == 'c') {


                $delivery = Delivery::find($id);

                if ($delivery && ! $delivery->paid) {

                    if ($obj['code'] == '1') {
                        // Pending
                        return redirect()->to(route('my-couriers') . '?pending=true');
                    } elseif ($obj['code'] == '0') {
                        // Delivered and paid
                        foreach ($delivery->packages as $package) {
                            if (! $package->paid) {
                                Transaction::addPackage($package->id, 'PORTMANAT', 'Kuryer sifarişi #' . $delivery->id);
                                $package->paid = true;
                                $package->save();
                            }
                        }
                        // Courier fee
                        Transaction::addDeliveryFee($delivery->id, $delivery->fee, 'PORTMANAT');

                        /* Send notification */
                        $message = null;
                        $message .= "🚚 💳 <b>" . $delivery->user->full_name . "</b> (" . $delivery->user->customer_id . ") ";
                        $message .= "Portmanat ilə " . $delivery->custom_id . " tracking kodu olan <b>kuryer parceli</b> üçün <b>" . $delivery->total_price . " AZN</b> ödəniş etdi.";

                        sendTGMessage($message);

                        /* make paid */
                        $delivery->paid = true;
                        $delivery->save();

                        return redirect()->to(route('my-couriers') . '?success=true');
                    } else {
                        $item = isset($package) ? $package : $delivery;
                        if ($item) {
                            // Error
                            Transaction::create([
                                'user_id'    => $item->user_id,
                                'custom_id'  => $item->id,
                                'paid_by'    => 'PORTMANAT',
                                'amount'     => null,
                                'type'       => 'ERROR',
                                'paid_for'   => 'PACKAGE',
                                'extra_data' => json_encode($obj),
                            ]);
                        }

                        $error = isset($obj['description']) ? $obj['description'] : 'Payment Error';

                        return redirect()->to(route('my-packages', ['id' => 2]) . '?error=' . $error);
                    }
                }
            } else {
                return redirect()->to(route('my-packages', ['id' => 2]) . '?error=package');
            }
        } else {
            return redirect()->to(route('my-packages', ['id' => 2]) . '?error=Payment Error');
        }
    }
}
