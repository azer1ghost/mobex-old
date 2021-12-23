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
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Artesaos\SEOTools\Facades\SEOTools as SEO;

/**
 * Class PayTrController
 *
 * @package App\Http\Controllers\Front\Payment
 */
class PayTrController
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function success(Request $request)
    {
        $orderId = $request->get('merchant_oid');
        $merchant_key = env('PAYTR_MERHCNAT_KEY');
        $merchant_salt = env('PAYTR_MERHCNAT_SALT');
        $payment_status = $request->get('status');
        $total_amount = $request->get('total_amount');
        $hash = $request->get('hash');

        $outHash = base64_encode(hash_hmac('sha256', $orderId . $merchant_salt . $payment_status . $total_amount, $merchant_key, true));

        $transaction = null;//Transaction::where('note', $orderId)->latest()->first();

        if ($hash != $outHash) {
            sendTGMessage("HASH : " . json_encode($request->all()));
            echo "ERROR";
            exit;
        }

        $added = substr($orderId, -12);
        $type = substr($added, 0, 2);
        $orderId = str_replace($added, "", $orderId);

        if ($type == '00') {
            $order = Order::where('id', $orderId)->withTrashed()->first();

            if ($order) {
                if ($payment_status == 'success') {

                    if ($transaction) {
                        $transaction->user_id = $order->user_id;
                        $transaction->custom_id = $order->id;
                        $transaction->paid_for = 'ORDER';
                        $transaction->currency = 'TRY';
                        $transaction->rate = getCurrencyRate(1) / getCurrencyRate(3);
                        $transaction->amount = $order->total_price;
                        $transaction->type = 'OUT';
                        $transaction->extra_data = json_encode($request->all());
                        $transaction->note = $order->id . ' id-li ordere görə ödəmə';
                        $transaction->save();
                    } else {
                        Transaction::create([
                            'user_id'    => $order->user_id,
                            'custom_id'  => $order->id,
                            'paid_by'    => 'PAY_TR',
                            'paid_for'   => 'ORDER',
                            'currency'   => 'TRY',
                            'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                            'amount'     => $order->total_price,
                            'type'       => 'OUT',
                            'note'       => $order->id . ' id-li ordere görə ödəmə',
                            'extra_data' => json_encode($request->all()),
                        ]);
                    }

                    Transaction::create([
                        'user_id'  => null,//$order->user_id,
                        'who'      => 'ADMIN',
                        'paid_for' => 'SERVICE_FEE',
                        'paid_by'  => 'PAY_TR',
                        'currency' => 'TRY',
                        'rate'     => getCurrencyRate(1) / getCurrencyRate(3),
                        'amount'   => $order->total_price * (env('PAYTR_FEE', 3) / 100),
                        'type'     => 'OUT',
                        'note'     => $order->id . ' id-li ordere görə PayTr Service fee ' . env('PAYTR_FEE', 3) . '%',
                    ]);

                    /* make paid */
                    $order->deleted_at = null;
                    $order->status = 1;
                    $order->paid = true;
                    $order->save();

                    if (env('APP_ENV') != 'local') {
                        $newOrder = Order::with(['country', 'links', 'user', 'admin'])->find($order->id);

                        Notification::sendOrder($newOrder->id, 1);

                        if ($newOrder->admin && $newOrder->admin->email) {
                            \Mail::to($newOrder->admin->email)->send(new OrderRequest($newOrder));
                        } else {
                            $country = Country::find($newOrder->country_id);

                            if ($country && $country->emails) {
                                $toAdmins = array_map('trim', explode(",", $country->emails));
                                if ($toAdmins) {
                                    @\Mail::to($toAdmins)->send(new OrderRequest($newOrder));
                                }
                            }
                        }

                        $message = "💸💸💸 <b>" . $newOrder->user->full_name . "</b> (#" . $newOrder->user->customer_id . ") ";
                        $message .= "<b>" . $newOrder->id . "</b>  id üçün <b>" . $newOrder->total_price . "TL</b> #PayTr ilə ödəmə etdi, " . ($newOrder->admin ? $newOrder->admin->name : 'operatorlar') . " məhsulları ala bilər!.";

                        sendTGMessage($message);
                    }
                } else {
                    $response = \GuzzleHttp\json_encode($request->all(), true);
                    Transaction::create([
                        'user_id'    => $order->user_id,
                        'custom_id'  => $order->id,
                        'paid_by'    => 'PAY_TR',
                        'paid_for'   => 'ORDER',
                        'currency'   => 'TRY',
                        'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                        'amount'     => $order->total_price,
                        'type'       => 'ERROR',
                        'extra_data' => $response,
                    ]);
                    $message = "🆘 <b>" . $order->user->full_name . "</b> (" . $order->user->customer_id . ") ";
                    $message .= "<b>" . $order->id . "</b>  id üçün başarısız ödəmə! Səbəb : " . ($request->get('failed_reason_msg'));
                    //sendTGMessage($message);
                }
            } else {
                sendTGMessage("Cannot find Order : " . json_encode($request->all()));
            }
        } elseif ($type == '11') {
            $user = User::find($orderId);
            if ($user) {
                $amount = $request->get('payment_amount') / 100;
                if ($payment_status == 'success') {

                    if ($transaction) {
                        $transaction->user_id = $user->id;
                        $transaction->custom_id = null;
                        $transaction->paid_for = 'ORDER_BALANCE';

                        $transaction->rate = getCurrencyRate(1) / getCurrencyRate(3);
                        $transaction->amount = $amount;
                        $transaction->type = 'IN';
                        $transaction->extra_data = json_encode($request->all());
                        $transaction->note = $user->id . '-li user sifariş balansını artırdı.';
                        $transaction->save();
                    } else {
                        Transaction::create([
                            'user_id'    => $user->id,
                            'custom_id'  => null,
                            'paid_by'    => 'PAY_TR',
                            'paid_for'   => 'ORDER_BALANCE',
                            'currency'   => 'TRY',
                            'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                            'amount'     => $amount,
                            'type'       => 'IN',
                            'note'       => $user->id . '-li user sifariş balansını artırdı.',
                            'extra_data' => json_encode($request->all()),
                        ]);
                    }

                    Transaction::create([
                        'user_id'   => null,//$user->id,
                        'custom_id' => null,
                        'who'       => 'ADMIN',
                        'paid_for'  => 'SERVICE_FEE',
                        'paid_by'   => 'PAY_TR',
                        'currency'  => 'TRY',
                        'rate'      => getCurrencyRate(1) / getCurrencyRate(3),
                        'amount'    => $amount * (env('PAYTR_FEE', 3) / 100),
                        'type'      => 'OUT',
                        'note'      => 'Sifariş balansı artırılması, PayTr Service fee ' . env('PAYTR_FEE', 3) . '%',
                    ]);

                    $message = "💵💵💵 <b>" . $user->full_name . "</b> (#" . $user->customer_id . ") ";
                    $message .= "<b>" . $amount . "TL</b> sifariş balansını #PayTR ilə artırdı!.";

                    sendTGMessage($message);
                } else {
                    $response = \GuzzleHttp\json_encode($request->all(), true);
                    Transaction::create([
                        'user_id'    => $user->id,
                        'custom_id'  => null,
                        'paid_by'    => 'PAY_TR',
                        'paid_for'   => 'ORDER_BALANCE',
                        'currency'   => 'TRY',
                        'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                        'amount'     => $amount,
                        'type'       => 'ERROR',
                        'extra_data' => $response,
                    ]);
                    $message = "🆘 <b>" . $user->full_name . "</b> (" . $user->customer_id . ") ";
                    $message .= "<b>Sifariş balansı</b>üçün başarısız ödəmə! Səbəb : " . ($request->get('failed_reason_msg'));
                    //sendTGMessage($message);
                }
            } else {
                sendTGMessage(json_encode($request->all()));
            }
        } else {
            sendTGMessage(json_encode($request->all()));
        }

        echo "OK";
        exit;
    }
}
