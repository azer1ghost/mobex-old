<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Label # {{ $item->id }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label # {{ $item->id }}</title>

    <style>
        .container {
            min-width: 500px;
            height: 95%;
            width: 95%;
            text-align: center;
        }
        html, body {
            height: 95%;
            width: 95%;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
            overflow: hidden !important;
            text-align: center;
        }

        @media print {
            @page {
                size: auto;  margin: 0mm;
                height: 95%;
                width: 95%;
                page-break-after: avoid !important;
                page-break-before: avoid !important;
                text-align: center;
            }

            html, body {
                height: 95%;
                width: 95%;
                page-break-after: avoid !important;
                page-break-before: avoid !important;
                overflow: hidden !important;
                text-align: center;
            }

            .print {
                display: none !important;
            }
            .rotated {
                margin: 0px;
                /*transform: rotate(90deg);*/
            }
        }
        main {
            position: absolute;
            left: 0;
            top: 0;
            text-align: center;
            padding-left: 10em;
        }

    </style>

</head>

<body>

<main>
    <div class="label">
        <?php $data = explode("-", $item->custom_id); ?>
        <div style="font-size: 15em; margin-bottom: 10px; text-decoration: underline ">{{ env('APP_NAME') }}</div>
        <div style="font-size: 10em;">KOLİ NO: {{ $data[0] }} @if(isset($data[1]))<div style="font-size: 55px !important;">-{{ $data[1] }}</div>@endif</div>
        <div style="font-size: 10em;">{{ $item->packages_count }} ADET</div>
        <div style="font-size: 10em;">{{ $item->packages->sum('weight') }} kg</div>
    </div>
</main>

</body>

</html>