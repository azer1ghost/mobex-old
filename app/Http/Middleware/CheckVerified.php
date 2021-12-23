<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;

class CheckVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()) {
            if (\Auth::user()->is_banned && ! request()->routeIs('banned')) {
                return redirect()->route('banned');
            }

            if (\Auth::user()->check_verify && \Auth::user()->verified == 0 && env('EMAIL_VERIFY')) {
                return redirect()->route('showResendVerificationEmailForm');
            }

            if (\Auth::user()->sms_verification_status == 0 && env('SMS_VERIFY')) {
                return redirect()->route('showResendVerificationSmsForm');
            }

            if (! \Auth::user()->fin && ! request()->routeIs('edit') && ! request()->routeIs('update')) {
                return redirect()->to(route('edit', ['nulled' => 'fin']) . '#info_section');
            }

            User::whereId(auth()->user()->id)->update([
                'login_at' => Carbon::now(),
            ]);
        }

        return $next($request);
    }
}
