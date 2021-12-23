<div class="col-lg-4 col-xl-3">
    <div class="aside-holder">
        <div class="shop__aside-close">
            <svg class="icon">
                <use xlink:href="#close"></use>
            </svg>
        </div>
        <div class="shop-aside">
            <div class="row">
                <div class="col-lg-12 bottom-20">
                    <form class="search-form">
                        <label style="display: none" for="search_input"></label>
                        <input value="{{ request()->get('q') }}" class="form__field"
                               type="text" id="search_input" name="q" placeholder="{{ __('front.search') }}"/>
                        <button class="form__submit" type="submit">
                            <svg class="icon">
                                <use xlink:href="#search"></use>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="col-lg-12 bottom-50">
                    <h5 class="catalog__title">{!! __('front.stores.categories') !!}</h5>
                    <ul class="category-list list--reset">
                        <li class="category-list__item">
                            <a class="category-list__link"
                               href="{{ route('shop') }}"><span>{!! __('front.stores.all') !!}</span><span>{!! $count_stores !!}</span></a>
                        </li>
                        @foreach($categories as $category)
                            <li class="category-list__item @if(request()->get('cat') == $category->id) item--active @endif"
                                value="{{ $category->id }}">
                                <a class="category-list__link"
                                   href="{{ route('shop','cat='.$category->id) }}"><span>{!! $category->translateOrDefault(app()->getLocale())->name !!}</span><span>{{ $category->stores->count() }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>