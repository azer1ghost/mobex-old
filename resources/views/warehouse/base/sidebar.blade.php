<ul class="navigation navigation-main navigation-accordion">

    <!-- Main -->
    <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
    @if($_logged->parcelling)
        <li>
            <a href="#"><i class="icon-barcode2"></i> <span>Parcels</span></a>
            <ul>
                <li {!! classActiveRoute('my.dashboard') !!}><a href="{{ route('my.dashboard') }}"><i
                                class="icon-barcode2"></i> <span>in Warehouse</span></a></li>

                <li {!! classActiveRoute('my.dashboard') !!}><a href="{{ route('w-parcels.index', 'ready') }}"><i
                                class="icon-airplane3"></i> <span>Ready</span></a></li>
                <li {!! classActiveRoute('my.dashboard') !!}><a href="{{ route('w-parcels.index', 'sent') }}"><i
                                class="icon-checkbox-checked"></i> <span>Sent</span></a></li>

            </ul>
        </li>
        <li {!! classActiveRoute('warehouse.stats') !!}><a href="{{ route('warehouse.stats') }}"><i
                        class="icon-chart"></i> <span>Stats</span></a></li>
    @endif
    <li>
        <a href="#"><i class="icon-package"></i> <span>Packages</span></a>
        <ul>
            <li {!! classActiveRoute('w-packages.index') !!}><a href="{{ route('w-packages.index') }}"><i
                            class="icon-package"></i> <span>Processing</span></a></li>

            <li {!! classActiveRoute('w-processed') !!}><a href="{{ route('w-processed', 'sent') }}"><i
                            class="icon-airplane3"></i> <span>Sent</span></a></li>
            <li {!! classActiveRoute('w-processed') !!}><a href="{{ route('w-processed') }}"><i
                            class="icon-checkbox-checked"></i> <span>Delivered</span></a></li>

        </ul>
    </li>
</ul>