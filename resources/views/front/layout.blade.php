<!DOCTYPE html>
<html lang="en">
<head>
@include('front.widgets.metaTags')

<!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">

    <!-- Stylesheets -->

    <link defer async href="{{ elixir('front/all.css') }}" rel="stylesheet" type="text/css">

    @include('front.widgets.ga')
    @include('front.widgets.gtm')
    @stack('css')
</head>


<!-- page wrapper -->
<body>

<div class="boxed_wrapper">

    <!-- preloader -->
    <div id="preloader" class="preloader" style="display: none"></div>
    <!-- preloader -->

@include('front.main.sections.header')
@include('front.main.sections.mobile_menu')

@yield('content')

@include('front.main.sections.footer')
@include('front.widgets.popup-banner')

<!--Scroll to top-->
    <button class="scroll-top scroll-to-target" data-target="html">
        <span class="fa fa-arrow-up"></span>
    </button>
</div>

<!-- jequery plugins -->
<script src="{{ elixir('front/all.js') }}"></script>

@stack('js')
</body>
<!-- End of .page_wrapper -->
</html>
