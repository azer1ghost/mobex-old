<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\TrendyolCode;
use Illuminate\Http\Request;

class TrendyolCodesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['throttle:100,1'])->except(['index']);
    }

    public function index()
    {
        return response()->json([
            'status' => 200,
            'message' => 'Ping worked'
        ]);
    }

    public function save(Request $request)
    {
       logger($request->all());

//        $message = $request->get('key');
//
//        $code = preg_match('/(?<!\d)\d{5,6}(?!\d)/', $message, $match) ? $match[0] : null;
//
//        TrendyolCode::create([
//            'code' => $code
//        ]);
    }
}
