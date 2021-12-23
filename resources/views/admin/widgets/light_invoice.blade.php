<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Invoice # {{ $item->id }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label # {{ $item->id }}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">

    <style>
        .tracking_section {
            width: 100%;
            position: absolute;
            bottom: 30px;
            text-align: center;
            display: none;
        }

        .tracking {
            width: auto;
            display: inline-block;
            height: 100px;
        }

        .cell {
            font-size: 50px;
            font-weight: 600;
            padding: 12px;
            border-radius: 7px;
            margin-left: 10px;
        }

        @media print {
            .tracking_section {
                display: block;
            }

            .tracking {
                height: 300px;
            }

            .cell {
                font-size: 90px;
                text-align: center;
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>

<div>
    @if($item->invoice && ! str_contains($item->invoice, 'doc') && ! str_contains($item->invoice, 'xls') && ! str_contains($item->invoice, 'pdf'))
        <div style="text-align: center; display: block">
            <img style="margin: 0 auto; height: 700px" src="{{ $item->invoice }}"/>
        </div>
    @else
        @include('front.widgets.' . $invoiceTemplate)
    @endif
</div>
<div class="tracking_section">
    @if ($item->tracking_code)
        <img class="tracking"
             src="http://barcode.tec-it.com/barcode.ashx?data={{ $item->custom_id }}&code=Code128&dpi=600&dataseparator="
             alt="">
    @endif
    <div style="width: 20%; display: inline-block">
        @if($item->parcel->count())
            <div class="cell">{{ $item->parcel->first()->name }}</div>
        @endif
    </div>
</div>
@if(request()->get('print'))
    <script>
        document.addEventListener("DOMContentLoaded", function(event){
            window.print();
            window.addEventListener("afterprint", function(event) {
                window.close();
            });
            window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
        });
    </script>
@endif

</body>

</html>