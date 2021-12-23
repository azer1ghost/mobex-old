<?php

namespace App\Http\Controllers\Front;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\District;
use App\Models\Extra\SMS;
use App\Models\Faq;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Store;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOTools as SEO;
use Illuminate\Http\Request;
use Mail;
use Validator;

/**
 * Class MainController
 *
 * @package App\Http\Controllers\Front
 */
class MainController extends Controller
{
    /**
     * @var mixed
     */
    protected $setting;

    /**
     * @var \Illuminate\Config\Repository|int|mixed|string|null
     */
    protected $lang;

    /**
     * MainController constructor.
     */
    public function __construct()
    {

        $this->setting = \Cache::remember('settings', 30 * 24 * 60 * 60, function () {
            return Setting::find(1);
        });
        $route = \Route::getCurrentRoute();
        $action = $route ? $route->getName() : 'shop';
        $cover = $this->cover($action);
        $this->lang = in_array(request()->segment(1), config('translatable.locales')) ? request()->segment(1) : config('translatable.fallback_locale');

        \View::share(['setting' => $this->setting, 'cover' => $cover]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pageTitle = __('seo.homepage.title');
        SEO::setTitle($pageTitle);
        SEO::setDescription(__('seo.homepage.description'));
        SEO::addImages(asset('uploads/setting/' . $this->setting->header_logo));

        $stores = \Cache::remember('stores', 30 * 24 * 60 * 60, function () {
            return Store::featured()->take(12)->latest()->get();
        });
        $countries = \Cache::remember('countries', 30 * 24 * 60 * 60, function () {
            return Country::with(['warehouse'])->where('status', 1)->has('warehouse')->get();
        });
        $mainWarehouse = \Cache::remember('main_warehouse', 30 * 24 * 60 * 60, function () {
            return (Country::with(['warehouse'])->where('status', 1)->has('warehouse')->orderBy('id', 'asc')->first())->warehouse;
        });

        //$promos = Coupon::featured()->take(4)->latest()->get();

        $news = Page::news()->latest()->paginate(3);

        $sliders = Slider::where('alert', false)->where('active', true)->take(3)->latest()->get();

        return view('front.new_main', compact('sliders', 'stores', 'countries', 'news', 'mainWarehouse'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq()
    {
        $faqs = Faq::orderBy('id', 'asc')->get();

        $breadTitle = $title = trans('front.menu.faq');

        $cover = $this->cover('faq');
        SEO::setTitle(__('front.menu.faq'));

        return view('front.pages.faq', compact('faqs', 'title', 'breadTitle', 'cover'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $page = Page::whereKeyword('about')->first();
        if (! $page) {
            abort('404');
        }
        $breadTitle = $title = trans('front.menu.about_us');
        $cover = $this->cover('about');
        SEO::setTitle(__('front.menu.about_us'));

        return view('front.pages.about.about_us', compact('title', 'breadTitle', 'cover'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function courier()
    {
        return view('front.pages.about.courier', compact('title', 'breadTitle', 'cover'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function contact()
    {
        $breadTitle = $title = trans('front.menu.contact_us');
        $cover = $this->cover('contact');
        SEO::setTitle(__('front.menu.contact'));

        if (\request()->isMethod('post')) {
            $validator = \Illuminate\Support\Facades\Validator::make(\request()->all(), [
                'c_name'    => 'required|min:3|max:255',
                'c_email'   => 'required|email|min:5|max:255',
                'c_subject' => 'required|min:3|max:255',
                'c_message' => 'required|min:5',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            Mail::send('front.mail.notification', [
                'name'    => \request()->get('c_name'),
                'content' => \request()->get('c_message'),
            ], function (
                $message
            ) {
                $message->subject(\request()->get('c_subject') . " - Bizimlə əlaqə");

                $message->from(\request()->get('c_email'), \request()->get('c_name'));

                $message->to("info@" . env('DOMAIN_NAME'));
            });

            return redirect()->to('contact#success')->with([
                'success' => true,
            ]);
        }

        return view('front.pages.contact', compact('breadTitle', 'title', 'cover'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function services()
    {
        $services = Service::orderBy('id', 'asc')->get();

        return view('front.pages.about.services', compact('services'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tariffs()
    {
        $showSubButtons = [
            ['route' => 'tariffs', 'label' => 'front.menu.tariffs'],
            ['route' => 'calculator', 'label' => 'front.menu.calculator'],
        ];
        $breadTitle = $title = trans('front.menu.tariffs');
        $countries = Country::with(['warehouse', 'pages'])->where('status', 1)->has('warehouse')->get();
        $countries_t = Country::has('warehouse')->where('status', true)->get();
        $cover = $this->cover('tariffs');
        SEO::setTitle(__('seo.tariff.title'));
        SEO::setDescription(__('seo.tariff.description'));
        $price = false;
        $result = null;

        if (request()->isMethod('post')) {
            $warehouse = (Country::with('warehouse')->find(request()->get('country')))->warehouse;
            if ($warehouse) {
                $result = $warehouse->calculateDeliveryPrice(request()->get('weight'), request()->get('weight_unit'), request()->get('width'), request()->get('height'), request()->get('length'), request()->get('length_unit'), true);

                if (! $result) {
                    $result = trans('front.enter_weight'); // 'Enter weight or any size'
                } else {
                    $price = true;
                }
            } else {
                $result = trans('front.no_any_warehouse'); // 'No any warehouse for this country';
            }
        }

        return view('front.pages.about.tariffs', compact('price', 'countries', 'countries_t', 'showSubButtons', 'breadTitle', 'title', 'result', 'cover'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calculator()
    {
        $showSubButtons = [
            ['route' => 'tariffs', 'label' => 'front.menu.tariffs'],
            ['route' => 'calculator', 'label' => 'front.menu.calculator'],
        ];
        $breadTitle = $title = trans('front.menu.calculator');
        $countries = Country::has('warehouse')->where('status', true)->get();
        $cover = $this->cover('calculator');
        SEO::setTitle(__('seo.calculator.title'));
        SEO::setDescription(__('seo.calculator.description'));
        $price = false;
        $result = null;

        if (request()->isMethod('post')) {
            $warehouse = (Country::with('warehouse')->find(request()->get('country')))->warehouse;
            if ($warehouse) {
                $user = auth()->check() ? auth()->user() : null;
                $result = $warehouse->calculateDeliveryPrice(request()->get('weight'), request()->get('weight_unit'), request()->get('width'), request()->get('height'), request()->get('length'), request()->get('length_unit'), true, $user);

                if (! $result) {
                    $result = trans('front.enter_weight'); // 'Enter weight or any size'
                } else {
                    $price = true;
                }
            } else {
                $result = trans('front.no_any_warehouse'); // 'No any warehouse for this country';
            }
        }

        return view('front.pages.calculator', compact('price', 'countries', 'showSubButtons', 'breadTitle', 'title', 'result', 'cover'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function news()
    {
        $validator = Validator::make(request()->all(), [
            'q' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Alert::error('Unexpected variables!');

            return redirect()->back();
        }
        $cover = $this->cover('news');

        $news = Page::news()->latest()->paginate(9);

        $breadTitle = $title = trans('front.menu.news');
        SEO::setTitle(__('seo.news.title'));
        SEO::setDescription(__('seo.news.description'));

        return view('front.pages.news', compact('news', 'title', 'breadTitle', 'cover'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function single($slug)
    {
        $page = PageTranslation::findBySlug(strtolower($slug));

        if (! $page) {

            return abort(404);
        }

        $single = Page::find($page->page_id);

        if (! $single) {
            return abort(404);
        }
        $pageTitle = $single->translateOrDefault(\App::getLocale())->meta_title ?: $single->translateOrDefault(\App::getLocale())->title;
        $content = $single->translateOrDefault(\App::getLocale())->meta_description ? $single->translateOrDefault(\App::getLocale())->meta_description : __('seo.news.description');

        SEO::setTitle($pageTitle);
        SEO::setDescription($content);
        if ($single->translateOrDefault(\App::getLocale())->meta_keywords) {
            \SEOMeta::addKeyword(explode(",", $single->translateOrDefault(\App::getLocale())->meta_keywords));
        }

        SEO::opengraph()->setUrl(request()->fullUrl());
        SEO::setCanonical(request()->fullUrl());
        SEO::addImages(asset($single->image));

        $breadTitle = $title = $single->translateOrDefault(app()->getLocale())->title;
        $cover = $this->cover('news');

        $similar = Page::news()->latest()->take(7)->get();

        return view('front.pages.single', compact('similar', 'single', 'title', 'breadTitle', 'cover'));
    }

    /**
     * @param $slug
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page($slug, Request $request)
    {
        $page = Page::whereKeyword($slug)->first();
        if (! $page) {
            abort('404');
        }

        $breadTitle = $title = $page->translateOrDefault(\App::getLocale())->title;
        $cover = $this->cover('news');

        $pageTitle = $page->translateOrDefault(\App::getLocale())->title;
        $content = $page->translateOrDefault(\App::getLocale())->meta_description ? $page->translateOrDefault(\App::getLocale())->meta_description : __('seo.news.description');
        SEO::setTitle($pageTitle);
        SEO::setDescription($content);
        SEO::addImages(asset($page->image));

        return view('front.pages.blank', compact('page', 'title', 'breadTitle', 'cover', 'pageTitle'));
    }

    /**
     * @param $key
     * @return string
     */
    public function cover($key)
    {
        $key .= "_cover";

        return $this->setting->{$key} ? asset('uploads/setting/' . $this->setting->{$key}) : asset('uploads/default/page-header.jpg');
    }

    /**
     * @return bool|string
     */
    public function calcPrice()
    {
        $country = Country::with('warehouse')->find((int) request()->get('country'));

        $warehouse = $country ? $country->warehouse : null;
        if ($warehouse) {
            $user = auth()->check() ? auth()->user() : null;
            $result = $warehouse->calculateDeliveryPrice((float) request()->get('weight'), 0, (float) request()->get('width'), (float) request()->get('height'), (float) request()->get('length'), 0, true, $user);
            if (! $result) {
                $result = "0.00 USD"; // 'Enter weight or any size'
            }
        } else {
            $result = "0.00 USD"; // 'No any warehouse for this country';
        }

        return $result;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDistricts()
    {
        $data = [];
        $districts = District::where('city_id', \request()->get('city_id'))->get();

        foreach ($districts as $district) {
            $data[] = [
                'id'   => $district->id,
                'name' => $district->name,
            ];
        }

        return response()->json($data);
    }

    /**
     * PDF Invoice for package
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PDFInvoice($id)
    {
        $cargoes = [
            [
                'name'   => 'ARAS',
                'number' => '0720039666',
            ],
            [
                'name'   => 'Trendyol Express',
                'number' => '8590921777',
            ],
        ];
        $item = Package::with(['user', 'warehouse', 'country'])->find($id);

        if (! $item) {
            return abort(404);
        }

        $cargo = $cargoes[rand(0, 1)];
        $shipper = $item->warehouse_id ? $item->warehouse : ($item->country ? $item->country->warehouse : null);

        $invoiceTemplate = ($shipper->country && strtoupper($shipper->country->code) == 'TR') ? 'new-invoice' : 'invoice';

        $pdf = \PDF::loadView('front.widgets.' . $invoiceTemplate, compact('item', 'shipper', 'cargo'));
        $r = $pdf->setPaper('a4')->setWarnings(false)->stream($id . '_invoice.pdf')->setCharset('UTF-8');

        return $r;
    }
}
