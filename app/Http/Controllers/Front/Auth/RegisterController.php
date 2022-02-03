<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Filial;
use App\Models\Promo;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Validator;

/**
 * Class RegisterController
 *
 * @package App\Http\Controllers\Front\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/register/verify/resend';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => [
                'verify',
            ],
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['passport'] = $data['passport_prefix'] . '-' . $data['passport_number'];
        $digits = 'digits:' . ($data['passport_prefix'] == 'AZE' ? 8 : 7);
        if ($data['promo']) {
            $data['promo'] = strtolower($data['promo']);
        }

        return Validator::make($data, [
            'name'            => 'required|string|max:30|regex:/(^([a-zA-Z]+)?$)/u',
            'surname'         => 'required|string|max:30|regex:/(^([a-zA-Z]+)?$)/u',
            'phone'           => 'required|string|unique:users',
            'passport_prefix' => 'required|in:AZE,AA',
            'passport_number' => 'required|' . $digits,
            'passport'        => 'required|string|unique:users',
            'gender'          => 'required|integer',
            'district'        => 'required',
            'city'            => 'required',
            'filial'          => 'required|exists:filials,id',
            'fin'             => 'required|alpha_num|unique:users',
            'email'           => 'required|email|string|max:255|unique:users',
            'password'        => 'required|string|min:6',
            'address'         => 'required|string|min:10',
            'promo'           => 'nullable|exists:promos,code',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $promo = null;
        if ($data['promo']) {
            $promo = Promo::where('code', $data['promo'])->where('status', 'ACTIVE')->first();

            // Limited use
            if ($promo && $promo->limited_use && $promo->users_count >= $promo->limited_use) {
                $promo->checked = true;
                $promo->status = 'PASSIVE';
                $promo->save();

                $promo = null;
            }
        }
        $user = User::create([
            'name'            => $data['name'],
            'surname'         => $data['surname'],
            'email'           => $data['email'],
            'password'        => $data['password'],
            'address'         => $data['address'],
            'passport'        => $data['passport_prefix'] . '-' . $data['passport_number'],
            'fin'             => $data['fin'],
            'gender'          => $data['gender'],
            'phone'           => $data['phone'],
            'customer_id'     => User::generateCode(),
            'city_id'         => $data['city'],
            'filial_id'       => $data['filial'],
            'district_id'     => $data['district'],
            'verified'        => ! env('EMAIL_VERIFY'),
            'promo_id'        => $promo ? $promo->id : null,
            'discount'        => $promo ? $promo->discount : 0,
            'liquid_discount' => $promo ? $promo->l_discount : 0,
        ]);

        $user->referral()->create(['referral_key' => \request()->get('referral_key')]);

        $discount = null;

        if ($promo && $promo->discount) {
            $discount = $promo->discount . "% daşıma haqqına endirim ";
        }

        if ($promo && $promo->order_balance) {
            Transaction::create([
                'user_id'    => $user->id,
                'custom_id'  => null,
                'paid_by'    => 'BONUS',
                'paid_for'   => 'ORDER_BALANCE',
                'currency'   => 'TRY',
                'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                'amount'     => $promo->order_balance,
                'type'       => 'IN',
                'note'       => $user->id . '-li user sifariş balansını ' . $promo->title . ' promo ilə artırdı.',
                'extra_data' => null,
            ]);
            $discount = $promo->order_balance . " TRY sifariş balansı ";
        }

        /*if ($promo && $promo->package_balance) {

        }*/

        session(['verification_email_sent' => 'yes']);

        $user = User::find($user->id);

        /* Send notification */
        $message = null;
        $message .= "✅ <b>" . $user->full_name . "</b> (" . $user->customer_id . ") ";
        $message .= ($user->city_name ? ($user->city_name . " şəhərindən ") : null) . "qeydiyyatdan keçdi.";
        if ($promo && $discount) {
            $message .= "<b>" . $promo->code . "</b> promo kodundan istifadə edib, " . $discount . " qazandı.";
        }

        //sendTGMessage($message);


        return $user;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $title = trans('front.menu.sign_up');
        $hideSideBar = $hideNavBar = true;
        $bodyClass = 'login-container login-cover  pace-done';
        $cityRel = City::whereHas('districts')->orderBy('id', 'asc');
        $cities = $cityRel->get();
        $districts = District::where('city_id', $cityRel->first()->id)->get();
        $filials = Filial::orderBy('id', 'asc')->get();

        return view('front.auth.register', compact('title', 'hideSideBar', 'hideNavBar', 'bodyClass', 'cities', 'districts', 'filials'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function showResendVerificationEmailForm()
    {
        $user = \Auth::user();

        if (! session('verification_email_sent') && ! $user->verified) {
            resolve('Lunaweb\EmailVerification\EmailVerification')->sendVerifyLink($user);
            session(['verification_email_sent' => 'yes']);
        }

        return view('emailverification::resend', ['verified' => $user->verified, 'email' => $user->email]);
    }

    /**
     * Resend the verification mail
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationEmail(Request $request)
    {
        $user = \Auth::user();

        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);
        $user->email = $request->get('email');
        $user->save();

        $sent = resolve('Lunaweb\EmailVerification\EmailVerification')->sendVerifyLink($user);
        \Session::flash($sent == EmailVerification::VERIFY_LINK_SENT ? 'success' : 'error', trans($sent));

        if ($sent == EmailVerification::VERIFY_LINK_SENT) {
            session(['verification_email_sent' => 'yes']);
        }

        return redirect($this->redirectPath());
    }
}