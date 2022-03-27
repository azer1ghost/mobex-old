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

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "105779825417323");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v13.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/tr_TR/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

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
