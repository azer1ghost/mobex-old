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
        .cell {
            font-size: 70px;
            font-weight: 600;
            padding: 12px;
            border: 1px solid #000;
            border-radius: 7px;
            margin-left: 10px;
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
<div style="width: 100%; position: absolute; top: 82%">
    @if ($item->tracking_code)
        <img style="width: 80%; display: inline-block" src="http://barcode.tec-it.com/barcode.ashx?data={{ $item->custom_id }}&code=Code128&dpi=600&dataseparator="
             alt="">
    @endif
    <div style="width: 20%; display: inline-block">
        @if($item->parcel->count())
            <div class="cell">{{ $item->parcel->first()->name }}</div>
        @endif
    </div>
</div>


</body>

</html>