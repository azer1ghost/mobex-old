<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth.api', 'throttle:100,1'])->except(['index']);
    }

    public function index()
    {
        return response()->json([
            'status' => 200,
            'message' => 'Ping worked'
        ]);
    }

    public function bonus(Request $request)
    {
        $key = $request->get('key');

        $referrals = Referral::where('referral_key', $key);

        if ($referrals->doesntExist()) {
            return response()->json([
                'status' => 404,
                'error' => 'user not found'
            ]);
        }

        $totalDeliveryPrice = 0;
        $total_packages = 0;
        $referralUsersCount = 0;

        foreach ($referrals->get() as $referral) {

            $lastRequestDate = $referral->getAttribute('request_time');

            $referralUser = $referral->user;

            $realPackages = $referralUser
                    ->packages()
                    ->where('paid', true)
                    ->where('status', 3)
                    ->whereNotNull('done_at');

            if($realPackages->count() > 0)
            {
                $referralUsersCount++;
            }

//            $realPackages->when($lastRequestDate, function ($query) use ($lastRequestDate) {
//                $query->whereDate('created_at', '>', $lastRequestDate);
//            });

            $total_packages += $realPackages->count();

            $totalDeliveryPrice += $realPackages->sum('delivery_price');
        }

        $referrals->update(['request_time' => now()]);

        return response()->json([
                'total_users' => $referrals->count(),
                'efficiency' => round($referralUsersCount/$referrals->count() * 100, 2),
                'total_earnings' =>  $totalDeliveryPrice * 1.7, //dollar
                'total_packages' => $total_packages,
            ]);
    }
}
