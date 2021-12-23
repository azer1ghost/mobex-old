<?php

namespace App\Http\Controllers\Front\Payment;

use Alert;
use App\Mail\OrderRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Extra\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;
use Artesaos\SEOTools\Facades\SEOTools as SEO;

/**
 * Class PaymesController
 *
 * @package App\Http\Controllers\Front\Payment
 */
class PaymesController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function request(Request $request)
    {
        $r = $request->all();
        if ($r) {
            $orderId = $request->get('id');
            $orderId = str_replace(substr($orderId, -12), "", $orderId);
            $order = Order::where('id', $orderId)->first();

            if ($order) {

                if ($request->get('message') == 'AUTHORIZED') {
                    Transaction::create([
                        'user_id'    => $order->user_id,
                        'custom_id'  => $order->id,
                        'paid_by'    => 'PAYMES',
                        'paid_for'   => 'ORDER',
                        'currency'   => 'TRY',
                        'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                        'amount'     => $order->total_price,
                        'type'       => 'OUT',
                        'extra_data' => json_encode($request->all()),
                    ]);

                    /* make paid */
                    $order->status = 1;
                    $order->paid = true;
                    $order->save();

                    $message = "💸💸💸  <b>" . $order->user->full_name . "</b> (" . $order->user->customer_id . ") ";
                    $message .= "<b>" . $order->id . "</b>  id üçün <b>" . $order->total_price . "TL</b> ödəmə etdi, " . ($order->admin ? $order->admin->name : 'operatorlar') . " məhsulları ala bilər!.";

                    sendTGMessage($message);

                    if (env('APP_ENV') != 'local') {
                        $newOrder = Order::with(['country', 'links', 'user'])->find($order->id);

                        Notification::sendOrder($order->id, 1);

                        if ($order->admin_id) {
                            \Mail::to($order->admin->email)->send(new OrderRequest($newOrder));
                        } else {
                            $country = Country::find($order->country_id);

                            if ($country && $country->emails) {
                                $toAdmins = array_map('trim', explode(",", $country->emails));
                                \Mail::to($toAdmins)->send(new OrderRequest($newOrder));
                            }
                        }
                    }

                    return redirect()->to(route('my-orders', ['id' => 1]) . '?success=payment');
                } else {
                    Transaction::create([
                        'user_id'    => $order->user_id,
                        'custom_id'  => $order->id,
                        'paid_by'    => 'PAYMES',
                        'paid_for'   => 'ORDER',
                        'currency'   => 'TRY',
                        'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                        'amount'     => $order->total_price,
                        'type'       => 'ERROR',
                        'extra_data' => json_encode($request->all()),
                    ]);
                    $message = "🆘 <b>" . $order->user->full_name . "</b> (" . $order->user->customer_id . ") ";
                    $message .= "<b>" . $order->id . "</b>  id üçün ödəmə uğurlu olmadı!. Səbəb : <b>" . (htmlspecialchars(html_entity_decode($request->get('message')))) . "</b>";

                    sendTGMessage($message);

                    return redirect()->to(route('my-orders', ['id' => 0]) . '?error=payment');
                }
            } else {
                //sendTGMessage(" no order :: " . $orderId . " " . json_encode($request->all()));

                return redirect()->to(route('my-orders', ['id' => 0]) . '?error=no_order');
            }
        }

        return redirect()->to(route('my-orders', ['id' => 1]) . '?error=no_request');
    }
}
