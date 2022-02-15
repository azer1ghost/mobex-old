<ul class="navigation navigation-main navigation-accordion">

    <!-- Main -->
    <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
    <li {!! classActiveRoute('dashboard') !!}><a href="{{ route('dashboard') }}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
    @permission('read-cells')
    <li {!! classActiveRoute('cells.index') !!}><a href="{{ route('cells.index') }}"><i class="icon-list-numbered"></i> <span>Packages/Cells</span></a></li>
    <li {!! classActiveRoute('cells.index') !!}><a href="{{ route('cells.index') }}?requested=1"><i class="icon-question3"></i> <span>Waiting</span>
            @if(isset($_packages['requested']))
                <span class="badge badge-danger align-self-center ml-auto">{{ $_packages['requested'] }}</span>
            @endif
        </a></li>
    @endpermission
    @permission('read-warehouses')
    <li>
        <a href="#"><i class="icon-office"></i> <span>Warehouse</span></a>
        <ul>
            @permission('read-warehouses')
            <li {!! classActiveRoute('warehouses.index') !!}><a href="{{ route('warehouses.index') }}"><i class="icon-office"></i> <span>Warehouses</span></a></li>
            @endpermission

            @permission('read-cities')
            <li {!! classActiveRoute('cities.index') !!}><a href="{{ route('cities.index') }}"><i class="icon-location3"></i> <span>Cities</span></a></li>
            @endpermission

            @permission('read-districts')
            <li {!! classActiveRoute('districts.index') !!}><a href="{{ route('districts.index') }}"><i class="icon-location3"></i> <span>Districts</span></a></li>
            @endpermission

            @permission('read-filials')
            <li {!! classActiveRoute('filials.index') !!}><a href="{{ route('filials.index') }}"><i class="icon-map4"></i> <span>Filials</span></a></li>
            @endpermission

            @permission('read-branches')
            <li {!! classActiveRoute('branches.index') !!}><a href="{{ route('branches.index') }}"><i class="icon-office"></i> <span>Branches</span></a></li>
            @endpermission

            @permission('read-countries')
            <li {!! classActiveRoute('countries.index') !!}><a href="{{ route('countries.index') }}"><i class="icon-location4"></i> <span>Countries</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission

    @permission('read-packages')
    <li>
        <a href="#"><i class="icon-package"></i> <span>Package</span></a>
        <ul>
            @permission('read-packages')
            <li {!! classActiveRoute('packages.index') !!}>
                <a href="{{ route('packages.index') }}">
                    <i class="icon-package"></i> <span>Packages</span>
                    @if(isset($_packages['active']))
                    <span class="badge badge-info align-self-center ml-auto">{{ $_packages['active'] }}</span>
                    @endif
                </a>
            </li>
            @endpermission

            @permission('read-unknowns')
            <li {!! classActiveRoute('unknowns.index') !!}><a href="{{ route('unknowns.index') }}"><i class="icon-close2"></i> <span>Unknowns</span>
                    @if(isset($_packages['unknown']))
                        <span class="badge badge-warning align-self-center ml-auto">{{ $_packages['unknown'] }}</span>
                    @endif
                </a>
            </li>
            @endpermission

            @permission('read-dones')
            <li {!! classActiveRoute('dones.index') !!}><a href="{{ route('dones.index') }}"><i class="icon-spinner"></i> <span>Completed</span>
                    @if(isset($_packages['done']))
                        <span class="badge badge-success align-self-center ml-auto">{{ $_packages['done'] }}</span>
                    @endif
                </a></li>
            @endpermission

            @permission('read-parcels')
            <li {!! classActiveRoute('parcels.index') !!}><a href="{{ route('parcels.index') }}"><i class="icon-barcode2"></i> <span>Parcels</span></a></li>
            @endpermission


            @permission('read-package_types')
            <li {!! classActiveRoute('package_types.index') !!}><a href="{{ route('package_types.index') }}"><i class="icon-list"></i> <span>Types</span></a></li>
            @endpermission

        </ul>
    </li>
    @endpermission

    @permission('read-transactions')
    <li {!! classActiveRoute('transactions.index') !!}><a href="{{ route('transactions.index') }}"><i class="icon-basket"></i> <span>Transactions</span></a></li>
    @endpermission

    @permission('read-deliveries')
    <li {!! classActiveRoute('deliveries.index') !!}>
        <a href="{{ route('deliveries.index') }}"><i class="icon-car2"></i> <span>Deliveries</span>
            @if(isset($_packages['deliveries']))
                <span class="badge badge-success align-self-center ml-auto">{{ $_packages['deliveries'] }}</span>
            @endif
        </a></li>
    @endpermission

    @permission('read-stores')
    <li>
        <a href="#"><i class="icon-price-tags"></i> <span>Store</span></a>
        <ul>
            @permission('read-stores')
            <li {!! classActiveRoute('stores.index') !!}><a href="{{ route('stores.index') }}"><i class="icon-apple2"></i> <span>Stores</span></a></li>
            @endpermission

            @permission('read-coupons')
            <li {!! classActiveRoute('coupons.index') !!}><a href="{{ route('coupons.index') }}"><i class="icon-qrcode"></i> <span>Coupons</span></a></li>
            @endpermission

            @permission('read-products')
            <li {!! classActiveRoute('products.index') !!}><a href="{{ route('products.index') }}"><i class="icon-display4"></i> <span>Products</span></a></li>
            @endpermission

            @permission('read-categories')
            <li {!! classActiveRoute('categories.index') !!}><a href="{{ route('categories.index') }}"><i class="icon-bag"></i> <span>Categories</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission

    @permission('read-orders')
    <li>
        <a href="#"><i class="icon-unlink"></i> <span>Buy for me</span></a>
        <ul>
            <li {!! classActiveRoute('orders.index') !!}><a href="{{ route('orders.index') }}"><i class="icon-unlink"></i> <span>Requests</span></a></li>

            @permission('read-cards')
            <li {!! classActiveRoute('cards.index') !!}><a href="{{ route('cards.index') }}"><i class="icon-credit-card"></i> <span>Cards</span></a></li>
            @endpermission
        </ul>
    </li>

    @endpermission

    @permission('read-users')
    <li {!! classActiveRoute('users.index') !!}><a href="{{ route('users.index') }}"><i class="icon-users"></i> <span>Users</span></a></li>
    @endpermission

    @permission('read-promos')
    <li {!! classActiveRoute('promos.index') !!}><a href="{{ route('promos.index') }}"><i class="icon-percent"></i> <span>Promos</span></a></li>
    @endpermission

    @permission('read-campaigns')
    <li {!! classActiveRoute('campaigns.index') !!}><a href="{{ route('campaigns.index') }}"><i class="icon-alarm"></i> <span>Campaigns</span></a></li>
    @endpermission

    @permission('read-news')
    <li {!! classActiveRoute('news.index') !!}><a href="{{ route('news.index') }}"><i class="icon-newspaper"></i> <span>News</span></a></li>
    @endpermission

    @permission('read-pages')
    <li>
        <a href="#"><i class="icon-file-empty"></i> <span>Page</span></a>
        <ul>
            @permission('read-pages')
            <li {!! classActiveRoute('pages.index') !!}><a href="{{ route('pages.index') }}"><i class="icon-files-empty"></i> <span>Pages</span></a></li>
            @endpermission

            @permission('read-faqs')
            <li {!! classActiveRoute('faqs.index') !!}><a href="{{ route('faqs.index') }}"><i class="icon-qrcode"></i> <span>FAQ</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission

    @permission('read-sliders')
    <li {!! classActiveRoute('sliders.index') !!}><a href="{{ route('sliders.index') }}"><i class="icon-images3"></i> <span>Slider/Popup</span></a></li>
    @endpermission

    @permission('read-sms')
    <li>
        <a href="#"><i class="icon-file-empty"></i> <span>Notifications</span></a>
        <ul>
            <li {!! classActiveRoute('notifications.index') !!}><a href="{{ route('notifications.index') }}"><i class="icon-list"></i> <span>Notifications</span></a></li>
            @permission('read-sms')
            <li {!! classActiveRoute('sms.index') !!}><a href="{{ route('sms.index') }}"><i class="icon-mobile"></i> <span>SMS Templates</span></a></li>
            @endpermission

            @permission('read-emails')
            <li {!! classActiveRoute('emails.index') !!}><a href="{{ route('emails.index') }}"><i class="icon-mail-read"></i> <span>Email Templates</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission


    @permission('read-gift_cards')
    <li {!! classActiveRoute('gift_card.index') !!}><a href="{{ route('gift_cards.index') }}"><i class="icon-gift"></i> <span>Gift Cards</span></a></li>
    @endpermission

    @permission('read-admins')
    <li>
        <a href="#"><i class="icon-user-tie"></i> <span>Admins</span></a>
        <ul>
            <li {!! classActiveRoute('admins.index') !!}><a href="{{ route('admins.index') }}"><i class="icon-user-tie"></i> <span>Admins</span></a></li>
            @permission('read-roles')
            <li {!! classActiveRoute('roles.index') !!}><a href="{{ route('roles.index') }}"><i class="icon-qrcode"></i> <span>Roles</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission

    @permission('read-settings')
    <li {!! classActiveRoute('settings.index') !!}><a href="{{ route('settings.edit', 1) }}"><i class="icon-gear"></i> <span>Settings</span></a></li>
    @endpermission

    @permission('read-translations')
    <li {!! classActiveRoute('settings.index') !!}><a href="{{ url('translations') }}"><i class="icon-code"></i> <span>Translations</span></a></li>
    @endpermission

    @permission('read-activities')
    <li {!! classActiveRoute('activities.index') !!}><a href="{{ route('activities.index') }}"><i class="icon-list"></i> <span>Activities</span></a></li>
    @endpermission

    @permission('read-logs')
    <li><a target="_blank" href="{{ route('system.logs') }}"><i class="icon-bug2"></i> <span>Logs</span></a></li>
    @endpermission

</ul>