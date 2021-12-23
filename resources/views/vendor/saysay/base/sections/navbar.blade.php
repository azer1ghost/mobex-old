<!-- Main navbar -->
<div class="navbar navbar-default header-highlightd">
    <div class="navbar-header">
        <a class="navbar-brand" href="/"><img src="{{ config('saysay.base.logo') }}" alt=""></a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
            </li>
        </ul>

        <div class="navbar-right">
            <p class="navbar-text"><span class="label bg-success">Online</span></p>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ $_avatar }}" alt="">
                        <span>{{ $_name }}</span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        @if ($_profileUrl)
                            <li><a href="{{ $_profileUrl }}"><i class="icon-cog5"></i> Account settings</a></li>
                        @endif
                        <li>
                            @include('vendor.saysay.base.elements.logout')
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->