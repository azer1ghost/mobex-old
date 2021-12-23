<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
@include('front.widgets.favicon')
<meta name="theme-color" content="#ffffff">
<meta name="robots" content="index,follow">
<meta name="ICBM" content="40.3905222, 49.8900936">
<meta name="geo.position" content="40.3905222;49.8900936">
<meta name="geo.region" content="AZ">
<meta name="geo.placename" content="Baku">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="skype_toolbar" content="skype_toolbar_parser_compatible">
{!! SEO::generate() !!}

<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
<link href='https://fonts.gstatic.com' rel='preconnect' crossorigin>
<link rel="preconnect" href="https://www.google-analytics.com" crossorigin>

<meta property="user_id" content="{{ auth()->check() ? auth()->user()->id : 0 }}"/>