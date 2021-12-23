<?php

namespace App\Http\Controllers\Front;

use Alert;
use App\Models\Category;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Store;
use Artesaos\SEOTools\Facades\SEOTools as SEO;
use Validator;

/**
 * Class ShopController
 *
 * @package App\Http\Controllers\Front
 */
class ShopController extends MainController
{
    /**
     *
     */
    public function generalShare()
    {

        $categories = Category::all();

        $showSubButtons = [
            ['route' => 'shop', 'label' => 'front.menu.shop'],
            ['route' => 'coupons', 'label' => 'front.menu.coupons'],
            ['route' => 'products', 'label' => 'front.menu.products'],
        ];

        \View::share([
            'showSubButtons' => $showSubButtons,
            'categories'     => $categories,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function stores()
    {
        $validator = Validator::make(\Request::all(), [
            'q'       => 'nullable|string',
            'cat'     => 'nullable|integer',
            'country' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            Alert::error('Unexpected variables!');

            return redirect()->back();
        }

        $this->generalShare();
        $categories = Category::whereHas('stores')->get();
        $countries = Country::whereHas('stores')->get();
        $items = Store::orderBy('id', 'asc');

        if (\Request::get('q') != null) {
            $items->whereTranslationLike('name', '%' . \Request::get('q') . '%');
        }
        if (\Request::get('cat') != null) {
            $cat = \Request::get('cat');
            $items->whereHas('categories', function ($query) use ($cat) {
                $query->where('store_categories.category_id', $cat);
            });
        }
        if (\Request::get('country') != null) {
            $country = \Request::get('country');
            $items->whereHas('country', function ($query) use ($country) {
                $query->where('country_id', $country);
            });
        }

        $count_stores = $items->count();

        $items = $items->paginate(12);

        $singleView = 'store';
        $cover = $this->cover('shop');
        $breadTitle = $title = trans('front.shop.title');

        SEO::setTitle(__('seo.shop.title'));
        SEO::setDescription(__('seo.shop.description'));

        return view('front.pages.shops.stores', compact('countries', 'count_stores', 'singleView', 'items', 'title', 'breadTitle', 'cover', 'categories'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function coupon($id)
    {
        $coupon = Coupon::find($id);

        return view('front.pages.stores.coupon-code', compact('coupon'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function coupons()
    {
        $validator = Validator::make(\Request::all(), [
            'q'   => 'nullable|string',
            'cat' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            Alert::error('Unexpected variables!');

            return redirect()->back();
        }

        $this->generalShare();
        $categories = Category::whereHas('coupons')->get();
        $items = Coupon::active()->latest();

        if (\Request::get('q') != null) {
            $items->whereTranslationLike('name', '%' . \Request::get('q') . '%');
        }
        if (\Request::get('cat') != null) {
            $cat = \Request::get('cat');
            $items->whereHas('categories', function ($query) use ($cat) {
                $query->where('coupon_categories.category_id', $cat);
            });
        }

        $items = $items->paginate(12);
        $singleView = 'coupon';
        $cover = $this->cover('shop');
        $breadTitle = $title = trans('front.coupon.title');

        return view('front.pages.stores', compact('singleView', 'items', 'title', 'breadTitle', 'cover', 'categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function products()
    {
        $validator = Validator::make(\Request::all(), [
            'q'   => 'nullable|string',
            'cat' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            Alert::error('Unexpected variables!');

            return redirect()->back();
        }

        $this->generalShare();
        $categories = Category::whereHas('products')->get();
        $items = Product::latest();
        if (\Request::get('q') != null) {
            $items->whereTranslationLike('name', '%' . \Request::get('q') . '%');
        }
        if (\Request::get('cat') != null) {
            $cat = \Request::get('cat');
            $items->whereHas('categories', function ($query) use ($cat) {
                $query->where('product_categories.category_id', $cat);
            });
        }
        $items = $items->paginate(12);

        $singleView = 'product';
        $cover = $this->cover('shop');
        $breadTitle = $title = trans('front.product.title');

        return view('front.pages.stores', compact('singleView', 'items', 'title', 'breadTitle', 'cover', 'categories'));
    }
}
