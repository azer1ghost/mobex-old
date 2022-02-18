<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" >
    <link href="https://mobilmanagement.com/assets/fonts/fontawesome.pro.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
    <title>Məntəqə</title>
    @stack('css')
</head>
<body>
    <nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">Mobex</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('branch.dashboard')}}">Məlumat paneli</a>
                    </li>
                </ul>
                <a class="btn btn-outline-warning" href="{{route('auth.logout')}}">
                    Çıxış
                </a>
            </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
