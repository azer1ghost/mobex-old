<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class EmanatController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $provider = explode("/", request()->path())[1];
        $this->provider = strtoupper($provider);
        dd($provider);
    }

    public function handler()
    {
        $type = request()->get('action') ?: 'unknown';

        if (method_exists($this, $type)) {
            return $this->{$type}();
        } else {
            return response()->json([
                'StatusCode'   => 4,
                'StatusDetail' => 'Required parameters is missing',
            ], 403);
        }
    }

    public function getCustomerId($customerId)
    {
        $customerId = strtoupper($customerId);
        $customerId = str_contains($customerId, env('MEMBER_PREFIX_CODE')) ? $customerId : (env('MEMBER_PREFIX_CODE') . $customerId);

        return $customerId;
    }

    public function check()
    {
        $validator = \Validator::make(\Request::all(), [
            'customer_id'    => 'required|string',
            'transaction_id' => 'required|string',
            'key'            => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'StatusCode'   => 4,
                'StatusDetail' => 'Required parameters is missing',
                'errors'       => $validator->errors(),
            ], 400);
        }

        $customerId = request()->get('customer_id');
        $transactionId = request()->get('transaction_id');
        $secretKey = env($this->provider . '_API_KEY');

        $key = md5($customerId . $transactionId . $secretKey);

        if ($key != request()->get('key')) {
            return response()->json([
                'StatusCode'   => 10,
                'StatusDetail' => 'Authorization error',
            ], 403);
        }

        $customerId = $this->getCustomerId($customerId);

        $user = User::where('customer_id', $customerId)->first();

        if ($user) {
            return response()->json([
                'StatusCode'   => 0,
                'StatusDetail' => 'OK',
                'DateTime'     => request()->get('datetime') ?: Carbon::now()->format("Y-m-d\Th:i:s"),
                'AccountInfo'  => [
                    'FullName'   => $user->full_name,
                    'CustomerId' => $user->customer_id,
                ],
            ]);
        } else {
            return response()->json([
                'StatusCode'   => 2,
                'StatusDetail' => 'Wrong account',
            ], 404);
        }
    }

    public function pay()
    {
        $validator = \Validator::make(\Request::all(), [
            'type'           => 'required|in:order,package',
            'datetime'       => 'required|string',
            'customer_id'    => 'required|string',
            'transaction_id' => 'required|string',
            'amount'         => 'required|numeric',
            'key'            => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'StatusCode'   => 4,
                'StatusDetail' => 'Required parameters is missing',
                'errors'       => $validator->errors(),
            ], 400);
        }

        $type = strtoupper(request()->get('type')) . "_BALANCE";
        $amount = request()->get('amount');
        $customerId = request()->get('customer_id');
        $transactionId = request()->get('transaction_id');
        $dateTime = Carbon::createFromFormat("Y-m-d\Th:i:s", request()->get('datetime'));
        $secretKey = env($this->provider . '_API_KEY');

        $key = md5($customerId . $transactionId . $amount . $secretKey);

        if ($key != request()->get('key')) {
            return response()->json([
                'StatusCode'   => 10,
                'StatusDetail' => 'Authorization error',
            ], 403);
        }

        $customerId = $this->getCustomerId($customerId);

        $user = User::where('customer_id', $customerId)->first();

        if ($user) {
            $transaction = Transaction::where('custom_id', $transactionId)->where('paid_by', $this->provider)->first();
            if ($transaction) {
                return response()->json([
                    'StatusCode'   => 3,
                    'StatusDetail' => 'Transaction Exist (Double)',
                ], 400);
            }

            $newTransaction = Transaction::create([
                'user_id'    => $user->id,
                'custom_id'  => $transactionId,
                'paid_by'    => $this->provider,
                'paid_for'   => $type,
                'currency'   => 'AZN',
                'rate'       => 1,
                'amount'     => $amount,
                'type'       => 'IN',
                'done_at'    => $dateTime,
                'note'       => $user->id . '-li user sifariş balansını artırdı.',
                'extra_data' => \GuzzleHttp\json_encode(request()->all()),
            ]);

            $message = "💵💵💵 <b>" . $user->full_name . "</b> (#" . $user->customer_id . ") ";
            $message .= "<b>" . $amount . "AZN </b> " . request()->get('type') . " balansını #" . $this->provider . " artırdı!.";

            sendTGMessage($message);

            return response()->json([
                'StatusCode'   => 0,
                'StatusDetail' => 'OK',
                'PaymentID'    => $newTransaction->id,
                'OrderDate'    => request()->get('datetime') ?: Carbon::now()->format("Y-m-d\Th:i:s"),
            ]);
        } else {
            return response()->json([
                'StatusCode'   => 2,
                'StatusDetail' => 'Wrong account',
            ], 404);
        }
    }

    public function status()
    {
        $validator = \Validator::make(\Request::all(), [
            'transaction_id' => 'required|string',
            'key'            => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'StatusCode'   => 4,
                'StatusDetail' => 'Required parameters is missing',
                'errors'       => $validator->errors(),
            ], 400);
        }

        $transactionId = request()->get('transaction_id');
        $secretKey = env($this->provider . '_API_KEY');

        $key = md5($transactionId . $secretKey);

        if ($key != request()->get('key')) {
            return response()->json([
                'StatusCode'   => 10,
                'StatusDetail' => 'Authorization error',
            ], 403);
        }

        $transaction = Transaction::where('custom_id', $transactionId)->where('paid_by', $this->provider)->first();

        if ($transaction) {
            $doneAt = Carbon::createFromTimeString($transaction->done_at);

            return response()->json([
                'StatusCode'   => 0,
                'StatusDetail' => 'OK',
                'PaymentID'    => $transaction->id,
                'Amount'       => $transaction->amount,
                'OrderDate'    => $doneAt->format("Y-m-d\Th:i:s"),
            ]);
        } else {
            return response()->json([
                'StatusCode'   => 22,
                'StatusDetail' => 'Transaction not found',
            ], 404);
        }
    }

    public function recon()
    {
        $validator = \Validator::make(\Request::all(), [
            'from_date' => 'required|string',
            'to_date'   => 'required|string',
            'sumpay'    => 'required|numeric',
            'count'     => 'required|integer',
            'key'       => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'StatusCode'   => 4,
                'StatusDetail' => 'Required parameters is missing',
                'errors'       => $validator->errors(),
            ], 400);
        }

        $from_date = request()->get('from_date');
        $to_date = request()->get('to_date');
        $sumPay = (float) request()->get('sumpay');
        $count = (int) request()->get('count');
        $secretKey = env($this->provider . '_API_KEY');

        $key = md5($from_date . $to_date . $sumPay . $count . $secretKey);

        if ($key != request()->get('key')) {
            return response()->json([
                'StatusCode'   => 10,
                'StatusDetail' => 'Authorization error',
            ], 403);
        }

        $from_date = Carbon::createFromFormat("Y-m-d\Th:i:s", request()->get('from_date'));
        $to_date = Carbon::createFromFormat("Y-m-d\Th:i:s", request()->get('to_date'));

        $transaction = Transaction::selectRaw('round(sum(amount), 2) as summy, count(id) as total')->where('done_at', ">=", $from_date)->where('done_at', "<=", $to_date)->where('paid_by', $this->provider)->first();

        if ($transaction) {

            if ($sumPay != $transaction->summy) {
                return response()->json([
                    'StatusCode'   => 16,
                    'StatusDetail' => 'Wrong Sum error',
                ], 403);
            }

            if ($count != $transaction->total) {
                return response()->json([
                    'StatusCode'   => 17,
                    'StatusDetail' => 'Wrong count error',
                ], 403);
            }

            return response()->json([
                'StatusCode'   => 0,
                'StatusDetail' => 'OK',
                'FromDate'     => request()->get('from_date'),
                'ToDate'       => request()->get('to_date'),
                'Sum'          => $sumPay,
                'Count'        => $count,
            ]);
        } else {
            return response()->json([
                'StatusCode'   => 22,
                'StatusDetail' => 'Transaction not found',
            ], 404);
        }
    }
}
