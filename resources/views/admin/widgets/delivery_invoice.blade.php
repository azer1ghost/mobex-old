<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} invoice #{{ $item->id }}</title>
    <meta name="author" content="harnishdesign.net">

    <!-- Web Fonts
    ======================= -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>

        body {
            background: #e7e9ed;
            color: #535b61;
            font-family: "Poppins", sans-serif;
            font-size: 14px;
            line-height: 22px;
        }

        form {
            padding: 0;
            margin: 0;
            display: inline;
        }

        img {
            vertical-align: inherit;
        }

        a, a:focus {
            color: #0071cc;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        a:hover, a:active {
            color: #0c2f55;
            text-decoration: none;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }
        @media print {
            @page {
                size: auto;
                margin: 0mm;
            }

            html, body {

                overflow: hidden !important;
            }
        }
        a:focus, a:active,
        .btn.active.focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn:active:focus,
        .btn:focus,
        button:focus,
        button:active {
            outline: none;
        }

        p {
            line-height: 1.9;
        }

        blockquote {
            border-left: 5px solid #eee;
            padding: 10px 20px;
        }

        iframe {
            border: 0 !important;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #0c2f54;
            font-family: "Poppins", sans-serif;
        }

        .table {
            color: #535b61;
        }

        .table-hover tbody tr:hover {
            background-color: #f6f7f8;
        }


        .text-1 {
            font-size: 12px !important;
            font-size: 0.75rem !important;
        }


        .bg-light-2 {
            background-color: #f8f8fa !important;
        }


        @media print {
            .table td, .table th {
                background-color: transparent !important;
            }

            .table td.bg-light, .table th.bg-light {
                background-color: #FFF !important;
            }

            .table td.bg-light-1, .table th.bg-light-1 {
                background-color: #f9f9fb !important;
            }

            .table td.bg-light-2, .table th.bg-light-2 {
                background-color: #f8f8fa !important;
            }

            .table td.bg-light-3, .table th.bg-light-3 {
                background-color: #f5f5f5 !important;
            }

            .table td.bg-light-4, .table th.bg-light-4 {
                background-color: #eff0f2 !important;
            }

            .table td.bg-light-5, .table th.bg-light-5 {
                background-color: #ececec !important;
            }
        }

        /* =================================== */
        /*  Layouts
        /* =================================== */
        .invoice-container {
            margin: 15px auto;
            padding: 70px;
            max-width: 850px;
            background-color: #fff;
            border: 1px solid #ccc;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            -o-border-radius: 6px;
            border-radius: 6px;
        }

        @media (max-width: 767px) {
            .invoice-container {
                padding: 35px 20px 70px 20px;
                margin-top: 0px;
                border: none;
                border-radius: 0px;
            }
        }

        .progress-bar,
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background-color: #0071cc;
        }

        .page-item.active .page-link,
        .custom-radio .custom-control-input:checked ~ .custom-control-label:before,
        .custom-control-input:checked ~ .custom-control-label::before,
        .custom-checkbox .custom-control-input:checked ~ .custom-control-label:before,
        .custom-control-input:checked ~ .custom-control-label:before {
            background-color: #0071cc;
            border-color: #0071cc;
        }

        .page-item.disabled .page-link {
            border-color: #f4f4f4;
        }
    </style>
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container">
    <!-- Header -->
    <header>
        <div class="row align-items-center">
            <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0"><img style="width: 170px" id="logo"
                                                                             src="{{ asset('assets/images/logo-3.png') }}"/>
            </div>
            <div class="col-sm-5 text-center text-sm-right">
                <h4 class="mb-0">Faktura</h4>
                <p class="mb-0">Faktura nömrə - {{ $item->custom_id }}</p>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row">
            <div class="col-sm-6 mb-3"><strong>Təhvil alacaq:</strong> <span>{{ $item->full_name }}</span></div>
            <div class="col-sm-6 mb-3 text-sm-right"><strong>Sorğu tarixi:</strong>
                <span>{{ $item->created_at->format('d/m/Y') }}</span></div>
        </div>
        <hr class="mt-0">
        <div class="row">
            <div class="col-sm-5"><strong>Çatdırılacaq ünvan:</strong>
                <address>
                    {{ $item->city->name }} {{ $item->district->name }}<br/>
                    {{ $item->address }}<br/>
                    T: {{ $item->cleared_phone }}<br/>
                </address>
            </div>
            <div class="col-sm-7">
                <div class="row">

                    <div class="col-sm-4"><strong>Müştəri kodu:</strong>
                        <p>{{ $item->user->customer_id }}</p>
                    </div>
                    <div class="col-sm-4"><strong>Göndərilib:</strong>
                        <p>{{ $item->updated_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-sm-4"><strong>Bağlama sayı:</strong>
                        <p>{{ $item->packages->count() }}</p>
                    </div>
                    <div class="col-sm-4"><strong>Sifariş ID:</strong>
                        <p>{{ uniqid() }}</p>
                    </div>
                    <div class="col-sm-4"><strong>Ödəmə yöntəmi:</strong>
                        <p>{{ $item->paid ? 'Online' : 'Nəğd' }}</p>
                    </div>
                    <div class="col-sm-4"><strong>Status:</strong>
                        <p>{!! $item->paid ? ' <b>ÖDƏNİLİB</b>' : 'Ödənməyib' !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header py-0">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <td class="col-5 border-0"><strong>Başlıq</strong></td>
                        <td class="col-3 text-right border-0"><strong>Çəkisi</strong></td>
                        <td class="col-4 text-right border-0"><strong>Qiyməti</strong></td>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <?php $paid = false; ?>
                        @foreach($item->packages as $package)
                            <?php $paid = $package->paid; ?>
                            <tr>
                                <td class="col-5 border-0">[<b>{{ $package->cell }}</b>] {{ $package->custom_id }}
                                    :: {{ $package->customs_type }}</td>
                                <td class="col-3 text-right border-0">{{ $package->weight }}kq</td>
                                <td class="col-4 text-right border-0" @if($package->paid) style="text-decoration: line-through;"@endif>{{ $package->delivery_manat_price }}AZN</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Kuryer xidməti</td>
                            <td class="text-right"></td>
                            <td class="text-right"@if($item->paid) style="text-decoration: line-through;"@endif> {{ $item->fee }}AZN</td>
                        </tr>


                        <tr>
                            <td colspan="2" class="bg-light-2 text-right"><strong>Paketlər üzrə:</strong></td>
                            <td class="bg-light-2 text-right"@if($paid && round($item->total_price - $item->fee, 2) > 0) style="text-decoration: line-through;"@endif>{{ round($item->total_price - $item->fee, 2) }}AZN</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bg-light-2 text-right"><strong>Xidmət:</strong></td>
                            <td class="bg-light-2 text-right"@if($item->paid) style="text-decoration: line-through;"@endif>{{ $item->fee }}AZN</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bg-light-2 text-right"><strong>Toplam:</strong></td>
                            <td class="bg-light-2 text-right"@if($item->paid) style="text-decoration: line-through;"@endif>{{ $item->total_price }}AZN</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($item->note)
            <br>
            <p class="text-1 text-muted"><strong>Qeyd:</strong> {{ $item->note }}</p>
        @endif
        <div class="row" style="margin-top: 40px">
            <div class="col-lg-7"></div>
            <div class="col-lg-5">İmza : <hr/></div>
        </div>
    </main>
</div>
</body>
</html>