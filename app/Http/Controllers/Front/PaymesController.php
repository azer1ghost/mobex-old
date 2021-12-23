<?php

namespace App\Http\Controllers\Front;

use Alert;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;
use Artesaos\SEOTools\Facades\SEOTools as SEO;

class PaymesController extends MainController
{
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
                        'paid_by'    => 'PAY_TR',
                        'paid_for'   => 'ORDER',
                        'currency'   => 'TRY',
                        'rate'       => getCurrencyRate(1)/getCurrencyRate(3),
                        'amount'     => $order->total_price,
                        'type'       => 'OUT',
                        'extra_data' => json_encode($request->all()),
                    ]);

                    /* make paid */
                    $order->status = 1;
                    $order->paid = true;
                    $order->save();

                    $message = "✅✅✅ <b>" . $order->user->full_name . "</b> (" . $order->user->customer_id . ") ";
                    $message .= "<b>" . $order->id . "</b>  id üçün ödemə edildi, operatorlar məhsulları ala bilər!.";

                    sendTGMessage($message);
                } else {
                    Transaction::create([
                        'user_id'    => $order->user_id,
                        'custom_id'  => $order->id,
                        'paid_by'    => 'PAY_TR',
                        'paid_for'   => 'ORDER',
                        'currency'   => 'TRY',
                        'rate'       => getCurrencyRate(1)/getCurrencyRate(3),
                        'amount'     => $order->total_price,
                        'type'       => 'ERROR',
                        'extra_data' => json_encode($request->all()),
                    ]);
                    $message = "🆘 <b>" . $order->user->full_name . "</b> (" . $order->user->customer_id . ") ";
                    $message .= "<b>" . $order->id . "</b>  id üçün başarısız ödeme!.";

                    sendTGMessage($message);
                }
            } else {
                sendTGMessage($orderId . " " . json_encode($request->all()));
            }

            echo "OK";
            exit;
        }

        echo "OK";
        exit;
    }
}
