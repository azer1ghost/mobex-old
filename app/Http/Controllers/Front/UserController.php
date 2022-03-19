<?php

namespace App\Http\Controllers\Front;

use App\Mail\OrderRequest;
use App\Models\Activity;
use App\Models\AzerpoctBranch;
use App\Models\Branch;
use App\Models\City;
use App\Models\Country;
use App\Models\Delivery;
use App\Models\District;
use App\Models\Extra\Notification;
use App\Models\Filial;
use App\Models\Link;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\Promo;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TrendyolCode;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Front
 */
class UserController extends MainController
{
    /**
     *
     */
    public function generalShare()
    {
        \View::share([
            'spending' => $this->spending(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addresses()
    {
        $this->generalShare();
        $countries = Country::with(['warehouses', 'pages'])->has('warehouse')->where('status', 1)->get();
        $breadTitle = $title = trans('front.user.addresses');

        return view('front.user.addresses', compact('countries', 'title', 'breadTitle'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filials()
    {
        if (auth()->check()) {
            $this->generalShare();
        }

        $filials = Filial::orderBy('id', 'asc')->get();
        $breadTitle = $title = trans('front.menu.filials');

        return view('front.user.filials', compact('filials', 'title', 'breadTitle'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders($id = 0)
    {
        $this->generalShare();
        $orders = Order::withCount('links')->whereUserId(\Auth::user()->id)->whereStatus($id)->orderBy('created_at', 'desc')->orderBy('status', 'ASC')->take(50)->get();

        $breadTitle = $title = trans('front.user.orders');

        $counts = (DB::table('orders')->select('status', DB::raw('count(*) as total'))->whereNull('deleted_at')->where('user_id', \Auth::user()->id)->groupBy('status')->pluck('total', 'status'))->all();

        return view('front.user.orders', compact('orders', 'breadTitle', 'title', 'id', 'counts'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cashback()
    {
        $stores = \Cache::remember('stores', 30 * 24 * 60 * 60, function () {
            return Store::featured()->take(6)->latest()->get();
        });

        $orders = Order::whereUserId(auth()->user()->id)->latest()->paginate(5);

        return view('front.user.cashback', compact('stores', 'orders'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function balance()
    {
        $this->generalShare();
        auth()->user()->orderBalance();

        $transactions = Transaction::where('type', '!=', 'ERROR')->whereUserId(auth()->user()->id)->latest()->paginate(20);

        if (\request()->isMethod('post')) {

            $validator = Validator::make(\request()->all(), [
                'promo' => 'required|string',

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $promo = Promo::where('code', \request()->get('promo'))->where('status', 'ACTIVE')->first();

            // Limited use
            if ($promo && $promo->limited_use && $promo->users_count >= $promo->limited_use) {
                $promo->checked = true;
                $promo->status = 'PASSIVE';
                $promo->save();

                $promo = null;
            }

            if (! $promo) {
                return redirect()->to(route('my-balance') . "?error=true");
            }

            $user = User::find(auth()->user()->id);
            $changed = false;

            if ($promo && $promo->discount && $promo->discount > $user->discount) {
                $user->discount = $promo->discount;
                $changed = true;
            }

            if ($promo && $promo->order_balance) {
                $activities = Activity::where('content_id', auth()->user()->id)->where('details', 'like', '%promo_id%')->get();

                $count = 0;
                $promos = [];

                foreach ($activities as $activity) {
                    $data = \GuzzleHttp\json_decode($activity->details, true);
                    $promos[] = $data['promo_id'];
                    if ($activity->created_at > Carbon::now()->subDays(30)) {
                        $count++;
                    }
                }

                if ($count < 3 && ! in_array($promo->id, $promos)) {
                    $changed = true;
                    Transaction::create([
                        'user_id'    => auth()->user()->id,
                        'custom_id'  => null,
                        'paid_by'    => 'BONUS',
                        'paid_for'   => 'ORDER_BALANCE',
                        'currency'   => 'TRY',
                        'rate'       => getCurrencyRate(1) / getCurrencyRate(3),
                        'amount'     => $promo->order_balance,
                        'type'       => 'IN',
                        'note'       => auth()->user()->id . '-li user sifariş balansını ' . $promo->code . ' promo ilə artırdı.',
                        'extra_data' => null,
                    ]);
                }
            }

            if ($changed) {
                $user->promo_id = $promo->id;
                $user->save();

                return redirect()->to(route('my-balance') . "?success=true");
            } else {
                return redirect()->to(route('my-balance') . "?error=true");
            }
        }

        return view('front.user.balance', compact('transactions'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function order($id)
    {
        $this->generalShare();
        $order = Order::with('links')->whereUserId(\Auth::user()->id)->find($id);
        if (! $order) {
            return abort(404);
        }

        $breadTitle = $title = trans('front.user.orders');

        return view('front.user.order', compact('order', 'breadTitle', 'title', 'id'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function panel()
    {
        $orders = Order::whereUserId(auth()->user()->id)->latest()->paginate(5);
        $order = Order::selectRaw('sum(total_price) as total')->whereUserId(auth()->user()->id)->where('created_at', '>=', Carbon::now()->subMonths(3))->first();
        $total = round($order->total / getCurrencyRate(3), 1);

        return view('front.user.panel', compact('orders', 'total'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function couriers()
    {
        $deliveries = Delivery::whereUserId(auth()->user()->id)->get();

        return view('front.user.couriers', compact('deliveries'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Exception
     */
    public function courierDelete($id)
    {
        $delivery = Delivery::whereUserId(\Auth::user()->id)->whereId($id)->first();
        if (! $delivery) {
            return abort(404);
        }

        if ($delivery->status) {
            return back();
        }
        /* Back to  */
        foreach ($delivery->packages as $package) {
            $package->status = 2;
            $package->save();
        }

        if ($delivery->paid && $delivery->fee) {
            $user = $delivery->user;

            $newTransaction = Transaction::create([
                'user_id'   => $user->id,
                'custom_id' => $delivery->id,
                'paid_by'   => 'OTHER',
                'paid_for'  => 'PACKAGE_BALANCE',
                'currency'  => 'AZN',
                'rate'      => 1,
                'amount'    => $delivery->fee,
                'type'      => 'IN',
                'note'      => $user->customer_id . '-li user daşıma balansını kuryer ödəməsi geri qaytarıldı.',
            ]);
        }

        $delivery->delete();

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function courier()
    {
        $cities = [
            0 => trans('front.city'),
        ];
        $districts = [];
        $item = auth()->user();
        $cityRel = City::whereHas('districts')->where('has_delivery', true)->orderBy('id', 'asc');
        $citiesObj = $cityRel->get();
        $districtsObj = District::where('city_id', $item->city_id)->where('has_delivery', true)->get();

        foreach ($citiesObj as $city) {
            $cities[$city->id] = $city->translateOrDefault(app()->getLocale())->name;
        }

        foreach ($districtsObj as $district) {
            $districts[$district->id] = $district->translateOrDefault(app()->getLocale())->name . " :: " . $district->delivery_fee . " ₼";
        }

        $users = [auth()->user()->id];
        foreach (auth()->user()->children as $user) {
            $users[] = $user->id;
        }
        $packages = Package::whereIn('user_id', $users)->where('status', 2)->get();

        if (\request()->isMethod('post')) {

            $validator = Validator::make(\request()->all(), [
                'note'        => 'nullable|string',
                'packages'    => 'required',
                'city_id'     => 'required|integer',
                'district_id' => 'required|integer',
                'full_name'   => 'required|string',
                'address'     => 'required|string',
                'phone'       => 'required|string',

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $added = [];
            $district = District::find(\request()->get('district_id'));
            $totalPrice = 0;
            $totalWeight = 0;

            foreach (\request()->get('packages') as $package => $enabled) {
                //dump($package);
                $myPackage = Package::whereIn('user_id', $users)->where('id', $package)->where('status', 2)->first();
                if ($myPackage) {
                    if (! $myPackage->paid) {
                        $totalPrice += floatval($myPackage->delivery_manat_price);
                    }

                    $totalWeight += $myPackage->weight;
                    $added[] = $myPackage->id;
                    $myPackage->status = 7;
                    $myPackage->save();
                }
            }
            if ($added && $district) {
                $delivery = new Delivery();
                $delivery->user_id = auth()->user()->id;
                $delivery->filial_id = auth()->user()->filial_id;
                $delivery->city_id = \request()->get('city_id');
                $delivery->district_id = $district->id;
                $delivery->address = \request()->get('address');
                $delivery->full_name = \request()->get('full_name');
                $delivery->phone = \request()->get('phone');
                $delivery->note = \request()->get('note');
                $delivery->fee = $district->delivery_fee;
                $delivery->total_weight = round($totalWeight, 2);
                $delivery->total_price = round($totalPrice + $district->delivery_fee, 2);
                $delivery->save();

                $delivery = Delivery::find($delivery->id);
                $delivery->packages()->sync($added);

                $message = null;
                $message .= "🚚🚚🚚 <b>" . auth()->user()->full_name . "</b> (" . auth()->user()->customer_id . ") ";
                $message .= count($added) . " ədəd paketini kuryerlə sifariş etdi. Toplam ödəyəcəyi məbləq " . $delivery->total_price . " AZN";

                //sendTGMessage($message);

                return redirect()->to(route('my-couriers') . "?added=true");
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        return view('front.user.courier', compact('cities', 'districts', 'packages', 'item'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDistricts()
    {
        $data = [];
        $districts = District::where('city_id', \request()->get('city_id'))->where('has_delivery', true)->get();

        foreach ($districts as $district) {
            $data[] = [
                'id'   => $district->id,
                'name' => $district->name . " :: " . $district->delivery_fee . " ₼",
            ];
        }

        return response()->json($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createOrder()
    {
        $this->generalShare();

        if (env('APP_ENV') == 'local') {
            $countriesObj = Country::all();
        } else {
            $countriesObj = Country::has('warehouse')->where('status', 1)->where('code', 'TR')->get();
        }
        $countries = [];
        $breadTitle = $title = trans('front.create_order_title');
        foreach ($countriesObj as $country) {
            $countries[$country->id] = $country->translateOrDefault(\App::getLocale())->name;
        }

        return view('front.user.create-order', compact('countries', 'breadTitle', 'title'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country'         => 'required|integer',
            'note'            => 'nullable|string',
            'url.*.link'      => 'nullable|url',
            'url.*.note'      => 'nullable|string',
            'url.*.amount'    => 'required|integer|min:1',
            'url.*.size'      => 'required|string',
            'url.*.color'     => 'nullable|string',
            'url.*.cargo_fee' => 'required|numeric|min:0|max:200',
            'url.*.price'     => 'required|numeric|min:1|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hasUrl = false;

        foreach ($request->get('url') as $url) {
            if ($url['link']) {
                $hasUrl = true;
            }
        }

        if (! $hasUrl) {
            return back()->with(['error' => true]);
        }

        $price = 0;

        foreach ($request->get('url') as $url) {
            if ($url['link']) {
                $price += (float) $url['price'] * (int) $url['amount'];

                if ($url['cargo_fee']) {
                    $price += (float) $url['cargo_fee'];
                }
            }
        }

        $price = round($price, 2);
        $fee = round($price * 0.05, 2);
        $total = round($price * 1.05, 2);

        // 1-14 fevral 0 faiz kompaniyasi
//        $fee = 0;
//        $total = round($price, 2);

        $order = new Order();
        $order->user_id = \Auth::user()->id;
        $order->country_id = $request->get('country');
        $order->note = $request->get('note');
        $order->custom_id = uniqid();
        $order->price = $price;
        $order->service_fee = $fee;
        $order->total_price = $total;
        $order->save();

        $links = [];
        foreach ($request->get('url') as $url) {
            if ($url['link']) {
                $link = new Link();
                $link->order_id = $order->id;
                $link->url = $url['link'];
                $link->note = $url['note'];
                $link->color = $url['color'];
                $link->size = $url['size'];
                $link->price = $url['price'];
                $link->cargo_fee = $url['cargo_fee'];
                $link->amount = $url['amount'];
                $link->total_price = (float) $url['price'] * (int) $url['amount'] + (float) $url['cargo_fee'];
                $link->save();
                $links[] = $link->id;
            }
        }

        $newOrder = Order::with(['country', 'links', 'user'])->find($order->id);
        /* Send notification */
        $message = null;
        $message .= "🔗 <b>" . auth()->user()->full_name . "</b> (" . auth()->user()->customer_id . ") ";
        $message .= $newOrder->country->name . " ölkəsi üzrə ";
        $message .= "<a href='http://panel." . env('DOMAIN_NAME') . "/orders/" . $newOrder->id . "/links'>" . count($links) . " ədəd link</a> sifariş etdi. Ödəməsini gözləyirik!";

        //sendTGMessage($message);

        return redirect()->route('payment', $order->id)->with(['success' => true]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteOrder($id)
    {
        $order = Order::whereUserId(auth()->user()->id)->where('id', $id)->first();

        if ($order) {
            $data = ['status' => 4];
            DB::table('orders')->where('id', $id)->update($data);

            $order->delete();

            return redirect()->back()->with(['deleted' => true]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteLink($id)
    {
        $link = Link::where('id', $id)->first();

        if ($link && $link->order->user_id == auth()->user()->id) {
            $link->delete();

            return redirect()->back()->with(['deleted' => true]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function packages($id = 0)
    {
        $this->generalShare();
        $breadTitle = $title = trans('front.user.packages');
        $packages = Package::whereUserId(\Auth::user()->id)->whereStatus($id);
        if (\Request::has('last_30_days')) {
            $startForExists = Carbon::now()->subDays(30)->format('Y-m-d h:i:s');
            $packages = $packages->where('created_at', '>=', $startForExists);
        }
        $packages = $packages->latest()->paginate(30);

        $counts = (DB::table('packages')->select('status', DB::raw('count(*) as total'))->whereNull('deleted_at')->where('user_id', \Auth::user()->id)->groupBy('status')->pluck('total', 'status'))->all();

        return view('front.user.packages', compact('packages', 'breadTitle', 'title', 'id', 'counts'));
    }

    /**
     * @param $id
     * @param bool $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function declaration($id, $page = false)
    {
        $item = Package::whereUserId(\Auth::user()->id)->whereId($id)->first();
        if (! $item) {
            return abort(404);
        }
        $categoriesObj = PackageType::with('children')->whereNull('parent_id')->whereNotNull('custom_id')->get();

        $categories = [];
        foreach ($categoriesObj as $category) {
            $categories[$category->id] = $category->translateOrDefault(\App::getLocale())->name;
            if ($category->children) {
                foreach ($category->children as $sub_category) {
                    $categories[$sub_category->id] = " - " . $sub_category->translateOrDefault(\App::getLocale())->name;
                }
            }
        }

        $countriesObj = Country::whereHas('warehouses')->orderBy('allow_declaration', 'desc')->orderBy('id', 'asc')->get();
        $countries = [];
        foreach ($countriesObj as $country) {
            if (! $country->allow_declaration) {
                $noDecCountries[] = $country->id;
            }
            $countries[$country->id] = $country->translateOrDefault(\App::getLocale())->name;
        }

        $view = 'front.user.declare';

        return view($view, compact('item', 'categories', 'countries'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function declarationUpdate($id)
    {
        $package = Package::whereUserId(\Auth::user()->id)->whereId($id)->first();
        if (!$package) {
            return back();
        }

        $validator = \Validator::make(\Request::all(), [
            'shipping_amount' => 'required|numeric|min:1|max:999999',
            'shipping_amount_cur' => 'required|integer',
            'type_id' => 'required|integer|not_in:0',
            'number_items' => 'required|integer',
            'website_name' => 'required|string',
            'i_agree' => 'required|boolean',
            'invoice' => 'nullable|mimes:jpeg,png,pdf,doc,docx,jpg,xls|max:4000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('declaration.edit', [
                'id' => $id,
                'page' => 'page',
            ])->withErrors($validator)->withInput();
        }

        $package = Package::whereUserId(\Auth::user()->id)->whereId($id)->first();

        if (!$package) {
            return abort(404);
        }

        $package->type_id = \Request::get('type_id');
        $package->shipping_amount = \Request::get('shipping_amount');
        $package->shipping_amount_cur = \Request::get('shipping_amount_cur');
        $package->number_items = \Request::get('number_items');
        $package->website_name = \Request::get('website_name');
        $package->has_liquid = \Request::get('has_liquid') != null ? 1 : 0;
        $package->user_comment = \Request::get('user_comment');
        $package->other_type = \Request::get('type_id') == env('OTHER_ID', 10) ? \Request::get('other_type') : null;
        $package->declaration = true;

        if (\Request::hasFile('invoice')) {
            $ext = \Request::file('invoice')->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;

            if (in_array(strtolower($ext), [
                'jpeg',
                'png',
                'pdf',
                'doc',
                'docx',
                'jpg',
                'xls',
            ])) {
                \Request::file('invoice')->move(public_path('uploads/packages/'), $fileName);
                $package->invoice = $fileName;
            }
        }

        $package->save();

        if ($package->custom_status < 2){
            auth()->user()->update(['refresh_customs' => true]);
        }
        return redirect()->route('my-packages', $package->status)->with(['success' => true]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Exception
     */
    public function declarationDelete($id)
    {
        $package = Package::whereUserId(\Auth::user()->id)->whereId($id)->first();
        if (! $package) {
            return abort(404);
        }
        /* Send notification */
        $message = null;
        $message .= "🛑 <b>" . auth()->user()->full_name . "</b> (" . auth()->user()->customer_id . ") ";
        $message .= "<a href='http://panel." . env('DOMAIN_NAME') . "/packages/" . $package->id . "/edit'>" . $package->tracking_code . "</a> tracking code ilə olan bəyannaməsini sildi!";
        sendTGMessage($message);

        $package->delete();

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function declarationCreate()
    {
        $categoriesObj = PackageType::with('children')->whereNull('parent_id')->whereNotNull('custom_id')->get();

        $noDecCountries = [];
        $categories = [];
        foreach ($categoriesObj as $category) {
            $categories[$category->id] = $category->translateOrDefault(\App::getLocale())->name;
            if ($category->children) {
                foreach ($category->children as $sub_category) {
                    $categories[$sub_category->id] = " - " . $sub_category->translateOrDefault(\App::getLocale())->name;
                }
            }
        }

        $countriesObj = Country::whereHas('warehouses')->orderBy('allow_declaration', 'desc')->orderBy('id', 'asc')->get();
        $countries = [];
        foreach ($countriesObj as $country) {
            if (! $country->allow_declaration) {
                $noDecCountries[] = $country->id;
            }
            $countries[$country->id] = $country->translateOrDefault(\App::getLocale())->name;
        }

        $view = 'front.user.declare';

        return view($view, compact('categories', 'countries', 'noDecCountries'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function declarationStore()
    {
        $country = Country::find((int) \Request::get('country_id'));
        if (! $country || ($country && ! $country->allow_declaration)) {
            return back()->withInput();
        }

        $validator = \Validator::make(\Request::all(), [
            'tracking_code'       => 'required|string|min:9|max:100',
            'country_id'          => 'required|integer',
            'shipping_amount'     => 'required|numeric|min:1|max:999999',
            'shipping_amount_cur' => 'required|integer',
            'type_id'             => 'required|integer|not_in:0',
            'other_type'          => 'nullable|string',
            'number_items'        => 'required|integer',
            'website_name'        => 'required|string',
            'invoice'             => 'required|mimes:jpeg,png,pdf,doc,docx,jpg,xls|max:4000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $code = \Request::get('tracking_code');
        $code = str_replace("Teslimat No: #", "", $code);
        $code = str_replace("#", "", $code);
        $code = str_replace(" ", "", $code);
        $code = str_replace("'", "", $code);
        $code = str_replace('"', "", $code);
        $orgCode = $code;

        if (starts_with($code, env('MEMBER_PREFIX_CODE'))) {
            return back()->with(['error' => true])->withInput();
        }

        $package = Package::likeTracking($code)->first();

        if (! $package && strlen($code) >= 10) {
            $start = -1 * strlen($code) + 1;
            for ($i = $start; $i <= -8; $i++) {
                $code = substr($code, $i);
                $package = Package::likeTracking($code)->first();

                if ($package) {
                    break;
                }
            }
        }

        if ($package && $package->user_id) {
            $validator->getMessageBag()->add('tracking_code', 'Bu tracking number ilə bağlama artıq var');

            return back()->withErrors($validator)->withInput();
        }

        if (! $package) {
            $package = new Package();
            $package->warehouse_id = null;
            $package->tracking_code = $orgCode;
            $package->country_id = \Request::get('country_id');
            $package->status = 6;
        }

        $package->user_id = \Auth::user()->id;
        $package->type_id = \Request::get('type_id');
        $package->shipping_amount = \Request::get('shipping_amount');
        $package->shipping_amount_cur = \Request::get('shipping_amount_cur');
        $package->number_items = \Request::get('number_items');
        $package->website_name = \Request::get('website_name');
        $package->has_liquid = \Request::get('has_liquid') != null ? 1 : 0;
        $package->user_comment = \Request::get('user_comment') ?: null;
        $package->other_type = \Request::get('type_id') == env('OTHER_ID', 10) ? \Request::get('other_type') : null;
        $package->declaration = true;

        if (\Request::hasFile('invoice')) {
            $ext = \Request::file('invoice')->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $ext;

            if (in_array($ext, [
                'jpeg',
                'png',
                'pdf',
                'doc',
                'docx',
                'jpg',
                'xls',
            ])) {
                \Request::file('invoice')->move(public_path('uploads/packages/'), $fileName);
                $package->invoice = $fileName;
            }
        }

        $package->save();

        /* Send notification */
        $message = null;
        $message .= "🥡 <b>" . auth()->user()->full_name . "</b> (" . auth()->user()->customer_id . ") ";
        $message .= "<a href='http://panel." . env('DOMAIN_NAME') . "/packages/" . $package->id . "/edit'>" . $package->tracking_code . "</a> tracking code ilə yeni bəyannamə yaratdı.";

        //sendTGMessage($message);

        return redirect()->route('my-packages', 6)->with(['success' => true]);
    }

    /**
     * @param null $nulled
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($nulled = null)
    {
        $this->generalShare();

        $item = \Auth::user();
        $breadTitle = $title = trans('front.user.profile');
        $cities = [
            0 => trans('front.city'),
        ];
        $districts = [
            0 => trans('front.district'),
        ];

        $cityRel = City::whereHas('districts')->orderBy('id', 'asc');
        $citiesObj = $cityRel->get();
        $districtsObj = District::where('city_id', $item->city_id)->get();

        $user = $item;
        if ($user->dealer) {
            $user = $user->dealer;
        }

        $users = [$user->id];
        foreach ($user->children as $sUser) {
            $users[] = $sUser->id;
        }

//        $hasInBaku = Package::whereIn('user_id', $users)->whereIn('status', [2, 7])->count();

        foreach ($citiesObj as $city) {
            $cities[$city->id] = $city->translateOrDefault(app()->getLocale())->name;
        }

        foreach ($districtsObj as $district) {
            $districts[$district->id] = $district->translateOrDefault(app()->getLocale())->name;
        }

//        $filials = [];
//
//        foreach (Filial::orderBy('id', 'asc')->get() as $filial) {
//            $filials[$filial->id] = $filial->translateOrDefault(app()->getLocale())->name . " -- " . $filial->translateOrDefault(app()->getLocale())->address;
//        }

//        $branches = [
//            'Seçilməyib'
//        ];

//        foreach (Branch::orderBy('id', 'asc')->get() as $branch) {
//            $branches[$branch->id] = $branch->translateOrDefault(app()->getLocale())->name . " -- " . $branch->translateOrDefault(app()->getLocale())->address;
//        }

        $azerpoct_branches = [
            'Seçilməyib'
        ];

        foreach (AzerpoctBranch::orderBy('id')->get() as $branch) {
            $azerpoct_branches[$branch->zip_code] = "$branch->postalDescription ($branch->home)";
        }

        return view('front.user.edit', compact('item', 'breadTitle', 'cities', 'districts', 'nulled', 'azerpoct_branches'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->merge(['passport' => $request->get('passport_prefix') . '-' . $request->get('passport_number')]);
        $digits = 'digits:' . ($request->get('passport_prefix') == 'AZE' ? 8 : 7);

        $this->validate($request, [
            'name'                   => 'required|string|max:30|regex:/(^([a-zA-Z]+)?$)/u',
            'surname'                => 'required|string|max:30|regex:/(^([a-zA-Z]+)?$)/u',
            'phone'                  => 'required|string|max:255|unique:users,phone,' . \Auth::user()->id,
            'passport_prefix'        => 'required|in:AZE,AA',
            'passport_number'        => 'required|' . $digits,
            'passport'               => 'required|string|max:255|unique:users,passport,' . \Auth::user()->id,
            'password'               => 'nullable|min:6|confirmed',
            'fin'                    => 'required|alpha_num|unique:users,fin,' . \Auth::user()->id,
            'company'                => 'nullable|max:100|string',
            'birthday'               => 'nullable|date',
            'address'                => 'required|string|min:10',
            'city_id'                => 'nullable|integer',
            'gender'                 => 'nullable|integer',
//            'filial_id'              => 'nullable|integer',
            'district_id'            => 'nullable|integer',
            'zip_code'               => 'nullable|string|min:3',
            'campaign_notifications' => 'nullable|integer',
            'auto_charge'            => 'nullable|integer',
            'sent_by_post'           => 'nullable|boolean',
        ]);

        $user = auth()->user();
        $user->name = $request->get('name');
        $user->surname = $request->get('surname');
        //$user->email = $request->get('email');

        // Refresh Customs packages
        if (($request->get('fin') != null && $user->fin != $request->get('fin')) || ($request->get('phone') != null && $user->phone != $request->get('phone'))) {
            $user->refresh_customs = true;
        }

        // Verify phone again
        if (($request->get('phone') != null && $user->phone != $request->get('phone'))) {
            $user->sms_verification_status = 0;
        }
        $user->phone = $request->get('phone');
        $user->passport = $request->get('passport');
        $user->gender = $request->get('gender', 1);
        $user->fin = $request->get('fin');
        $user->company = $request->has('company') ? $request->get('company') : null;
        $user->birthday = $request->has('birthday') ? $request->get('birthday') : null;
        $user->address = $request->has('address') ? $request->get('address') : null;
        $user->city_id = $request->has('city_id') ? $request->get('city_id') : null;
//        $user->filial_id = $request->get('filial_id');

//        if ($request->has('filial_id') && $request->get('sent_to') === 'filial' && $request->get('filial_id') != null) {
//            $user->filial_id = $request->get('filial_id');
//            $user->branch_id = null;
//        }

        $user->district_id = $request->has('district_id') ? $request->get('district_id') : null;
        $user->zip_code = $request->has('zip_code') ? $request->get('zip_code') : null;
        $user->campaign_notifications = $request->has('campaign_notifications') ? 1 : 0;
        $user->auto_charge = $request->has('auto_charge') ? 1 : 0;
        $user->sent_by_post = $request->has('sent_by_post') ? 1 : 0;

        if ($request->has('password') && $request->get('password') != null) {
            $user->password = $request->get('password');
        }

        $user->save();

        return redirect()->route('edit')->with(['success' => true]);
    }

    /**
     * @return array
     */
    public function spending()
    {
        $startForExists = Carbon::now()->firstOfMonth()->format('Y-m-d h:i:s');

        $data = Package::where('user_id', \Auth::user()->id)->where('custom_status', '>', 0)->whereNotNull('arrived_at')->where('arrived_at', '>=', $startForExists)->get();
        $waiting = Package::where('user_id', \Auth::user()->id)->whereIn('status', [0, 1])->count();

        $counts = [
            'sum'   => 300,
            'total' => $waiting,
        ];

        if ($data) {
            foreach ($data as $package) {
                $counts['sum'] -= $package->total_price;
            }
        }

        $counts['sum'] = round($counts['sum'], 1);

        return $counts;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function banned()
    {
        if (! auth()->user()->is_banned) {
            return redirect()->route('my-packages');
        }
        $this->generalShare();
        $breadTitle = $title = 'Opps';

        return view('front.user.banned', compact('breadTitle', 'title'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function payment($id)
    {
        $this->generalShare();
        $order = Order::where('id', $id)->first();
        if (! $order) {
            return back();
        }

        return view('front.user.payment', compact('order'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function payTR($id)
    {

        $order = Order::whereUserId(auth()->user()->id)->where('id', $id)->first();

        if (! $order || $order->paid) {
            return redirect()->back();
        } else {
            $amount = $order->total_price;

            $user_basket = base64_encode(json_encode([
                ["Payment for Order : " . $order->id, $amount, 1],
            ]));

            $merchant_oid = $order->id . "00" . Carbon::now()->getTimestamp();

            return $this->payTRView($amount, $user_basket, $merchant_oid);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function deposit()
    {
        $amount = (float) \request()->get('amount');

        $user_basket = base64_encode(json_encode([
            ["Deposit Order Balance for #User " . auth()->user()->id, $amount, 1],
        ]));

        $merchant_oid = auth()->user()->id . "11" . Carbon::now()->getTimestamp();

        return $this->payTRView($amount, $user_basket, $merchant_oid);
    }

    /**
     * @param $amount
     * @param $user_basket
     * @param $merchant_oid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function payTRView($amount, $user_basket, $merchant_oid)
    {

        if ((float) $amount < 1) {
            return redirect()->back();
        }

        ## 1. ADIM için örnek kodlar ##

        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        #
        ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
        $merchant_id = env('PAYTR_MERHCNAT_ID');
        $merchant_key = env('PAYTR_MERHCNAT_KEY');
        $merchant_salt = env('PAYTR_MERHCNAT_SALT');
        #
        ## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
        $email = auth()->user()->email;
        #
        ## Tahsil edilecek tutar.
        $payment_amount = $amount * 100;

        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
        $user_name = auth()->user()->full_name;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
        $user_address = auth()->user()->address;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
        $user_phone = auth()->user()->phone;
        #
        ## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_ok_url = route('my-orders') . "?success=true";
        #
        ## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_fail_url = route('my-orders') . "?error=true";
        #

        $ip = getIP();

        ## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
        ## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
        $user_ip = env('APP_ENV') == 'local' ? '84.17.62.195' : $ip;
        ##

        ## İşlem zaman aşımı süresi - dakika cinsinden
        $timeout_limit = "30";

        ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
        $debug_on = 1;

        ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
        $test_mode = 0;

        $no_installment = 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

        ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
        ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
        $max_installment = 0;

        $currency = "TL";

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
        $hashed = hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true);
        $paytr_token = base64_encode($hashed);

        /* Transaction::create([
             'user_id'  => auth()->user()->id,
             'paid_by'  => 'PAY_TR',
             'paid_for' => 'ORDER',
             'currency' => 'TRY',
             'type'     => 'ERROR',
             'amount'   => $amount,
             'note'     => $merchant_oid,
             'hash'     => $paytr_token,
         ]);*/

        $post_vals = [
            'merchant_id'       => $merchant_id,
            'user_ip'           => $user_ip,
            'merchant_oid'      => $merchant_oid,
            'email'             => $email,
            'payment_amount'    => $payment_amount,
            'paytr_token'       => $paytr_token,
            'user_basket'       => $user_basket,
            'debug_on'          => $debug_on,
            'no_installment'    => $no_installment,
            'max_installment'   => $max_installment,
            'user_name'         => $user_name,
            'user_address'      => $user_address,
            'user_phone'        => $user_phone,
            'merchant_ok_url'   => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit'     => $timeout_limit,
            'currency'          => $currency,
            'test_mode'         => $test_mode,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = @curl_exec($ch);

        $token = null;
        $error = null;
        if (curl_errno($ch)) {
            $error = "PAYTR IFRAME connection error. err:" . curl_error($ch);
        }

        curl_close($ch);

        $result = json_decode($result, 1);

        if ($result && isset($result['status']) && isset($result['token']) && $result['status'] == 'success') {
            $token = $result['token'];
        } else {
            $message = is_array($result) ? \GuzzleHttp\json_encode($result) : $result;
            sendTGMessage("#PayTr #Error : " . $message);
            $error = "Xəta baş verdi : " . (isset($result['reason']) ? $result['reason'] : 'Qeyri müəyyən');
        }
        if ($error) {
            return redirect()->back()->with(['error' => $error]);
        }

        return view('front.user.payments.paytr', compact('token'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function paymes($id)
    {
        $order = Order::whereUserId(auth()->user()->id)->where('id', $id)->first();

        if (! $order || $order->paid) {
            return redirect()->back();
        }

        if (\request()->isMethod('post')) {

            $data = [
                'number'      => str_replace(" ", "", \request()->get('number')),
                'owner'       => \request()->get('name'),
                'cvv'         => \request()->get('cvv'),
                'expiryMonth' => explode("/", \request()->get('date'))[0],
                'expiryYear'  => explode("/", \request()->get('date'))[1],
            ];

            $test = [
                'cvv'         => '680',
                'expiryYear'  => '23',
                'expiryMonth' => '11',
                'number'      => '4725876597651487',
                'owner'       => 'Mobil Express',
            ];

            $m_id = $order->id . "00" . Carbon::now()->getTimestamp();
            $r = [
                'secret'              => env('PAYMES_KEY'),
                'productQuantity'     => '1',
                'productSku'          => '1',
                'productName'         => 'Payment for order #' . $id . " by " . auth()->user()->customer_id,
                'comment'             => "There are " . $order->links->count() . " links",
                'clientIp'            => getIP(),
                'deliveryFirstname'   => 'Mobil',
                'deliveryLastname'    => 'Express',
                'billingCity'         => 'Baku',
                'billingAddressline1' => auth()->user()->address,
                'billingCountrycode'  => 'TR',
                'billingPhone'        => auth()->user()->cleared_phone,
                'billingEmail'        => auth()->user()->email,
                'billingFirstname'    => auth()->user()->name,
                'billingLastname'     => auth()->user()->surname,
                'installmentsNumber'  => 1,
                'amount'              => 1,
                'productPrice'        => $order->total_price,
                'currency'            => 'TRY',
                'operationId'         => $m_id,
            ];

            if (env('APP_ENV') == 'local') {
                $r = array_merge($r, $test);
            } else {
                $r = array_merge($r, $data);
            }

            $response = \GuzzleHttp\json_decode(curlPostRequest("https://web.paym.es/api/authorize", $r), true);

            if ($response && isset($response['status']) && $response['status'] == 'SUCCESS' && isset($response['paymentResult']['url'])) {
                return redirect()->to($response['paymentResult']['url']);
            } else {

                sendTGMessage(\GuzzleHttp\json_encode($response));

                return redirect()->back()->with(["error" => "Error"]);
            }
            //dd($response);
        }

        return view('front.user.payments.paymes', compact('order'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payOrder($id)
    {

        $order = Order::whereUserId(auth()->user()->id)->where('id', $id)->first();

        if (! $order || $order->paid) {
            return redirect()->back();
        }

        if (\request()->get('method') == 'balance') {
            if ($order->total_price <= auth()->user()->orderBalance()) {

                Transaction::create([
                    'user_id'   => $order->user_id,
                    'custom_id' => $order->id,
                    'paid_by'   => 'ORDER_BALANCE',
                    'paid_for'  => 'ORDER',
                    'currency'  => 'TRY',
                    'rate'      => getCurrencyRate(1) / getCurrencyRate(3),
                    'amount'    => $order->total_price,
                    'type'      => 'OUT',
                ]);

                /* make paid */
                $order->status = 1;
                $order->paid = true;
                $order->save();

                $message = "💸💸💸 <b>" . $order->user->full_name . "</b> (" . $order->user->customer_id . ") ";
                $message .= "<b>" . $order->id . "</b>  id üçün <b>" . $order->total_price . "TL</b> sifariş balansından ödədi, " . ($order->admin ? $order->admin->name : 'operatorlar') . " məhsulları ala bilər!.";

                sendTGMessage($message);

                return redirect()->to(route('my-orders', ['id' => 1]))->with(['success' => true]);
            } else {
                return redirect()->back();
            }
        } else {
            if (env('PAYMENT') == 'PAYMES') {
                return redirect()->route('my-orders.paymes', $id);
            }

            if (env('PAYMENT') == 'PAYTR') {
                return redirect()->route('my-orders.paytr', $id);
            }
        }

        return redirect()->route('my-orders');
    }

    public function trendyolVerifyCode()
    {
        return view('front.user.trendyol-verify');
    }

    public function getTrendyolCodes()
    {
        TrendyolCode::where('created_at', '<', now()->subMinutes(3))->delete();

        return response()->json(
            TrendyolCode::pluck('code')
        );
    }
}
