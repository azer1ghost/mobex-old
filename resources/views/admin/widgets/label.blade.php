<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Label # {{ $item->id }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label # {{ $item->id }}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
    <style>
        .container {
            min-width: 500px;
            height: 95%;
            width: 95%;
        }

        html, body {
            height: 95%;
            width: 95%;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
            overflow: hidden !important;
        }

        @media print {
            @page {
                size: auto;
                margin: 0mm;
                height: 95%;
                width: 95%;
                page-break-after: avoid !important;
                page-break-before: avoid !important;
            }

            html, body {
                height: 95%;
                width: 95%;
                page-break-after: avoid !important;
                page-break-before: avoid !important;
                overflow: hidden !important;
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
        }

        .print {
            position: absolute;
            right: 30px;
            top: 30px;
            display: block;
            float: right;
            border: 1px solid #000;
            margin-right: 21px;
            padding: 15px;
            border-radius: 6px;
            font-weight: 600;
            background: #f1f1f1;
            cursor: pointer;
        }

        .label {
            width: 575px;
            height: 575px;
            padding: 20px 5px 0px 20px;
        }

        .info {
            width: 410px;
            height: 575px;
        }

        .tracking_code {

        }

        .tracking_code img {
            height: 155px;
            position: relative;
            width: 565px;
            top: -371px;
            left: 210px;
            -ms-transform: rotate(-90deg);
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }

        .info, .tracking_code {
            display: inline-block;
        }

        .sender, .receiver {
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            min-height: 250px;
            width: 360px;
            border: 1px solid #000;
            margin-left: 40px;
        }

        .receiver {
            min-height: 285px;
        }

        .sender {
            margin-bottom: 25px;
        }

        .title {
            margin: 0 10px;
            font-weight: 600;
            border-bottom: 2px solid #000;
            padding: 11px;
            font-size: 20px;
            text-transform: uppercase;
        }

        .title span {
            font-size: 26px;
        }

        .title .sub-title {
            font-size: 17px;
            font-weight: 500;
        }

        .items {
            padding: 15px 15px 11px 15px;
        }

        .item {
            display: block;
            margin-bottom: -9px;
        }

        .key {
            font-weight: 600;
            width: 35%;
        }

        .value, .key {
            display: inline-block;
            font-size: 15px;
        }

        .value {
            width: 57%;
        }

        .dot {
            display: inline-block;
            width: 5%;
            font-weight: 600;
            font-size: 23px;
        }

        .sender_title {
            position: absolute;
            -ms-transform: rotate(-90deg);
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
            left: -25px;
            font-size: 33px;
            top: 100px;
        }

        .rec_title {
            position: absolute;
            -ms-transform: rotate(-90deg);
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
            left: -35px;
            font-size: 33px;
            top: 390px;
        }

        .cell {
            position: absolute;
            top: 190px;
            left: 330px;
            font-size: 50px;
            font-weight: 600;
            padding: 0px 12px;
            border: 1px solid #000;
            border-radius: 7px;
        }

    </style>

</head>

<body>

<main>
    <div class="label">
        <div class="info">
            <div class="sender">
                <div class="sender_title">SENDER</div>
                <div class="title">
                    {{ $item->website_name ?: 'Trendyol' }}
                    <div class="sub-title">{{ env('MEMBER_PREFIX_CODE') }}{{ sprintf("%06d", $item->id) }}</div>
                    <div style="font-size: 15px;position: absolute;top: 62px;left: 227px;">
                        @if($item->reg_number)
                            RN: {{ $item->reg_number }}
                        @else
                            Date: {{ $item->sent_at ? $item->sent_at->format('Y-m-d h:i') : (Carbon\Carbon::now()->format('Y-m-d h:i')) }}
                        @endif
                    </div>
                </div>
                <div class="items">
                    <div class="item">
                        <div class="key">Category</div>
                        <div class="dot">:</div>
                        <div class="value"><?= str_limit(strtoupper(str_slug($item->detailed_type ?: 'Diger', " ")), 25) ?></div>
                    </div>
                    <div class="item">
                        <div class="key">Items</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->number_items or '-' }}</div>
                    </div>
                    <div class="item">
                        <div class="key">Weight</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->weight_with_type }}</div>
                    </div>

                    <div class="item">
                        <div class="key">Price</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->shipping_org_price ? $item->shipping_org_price : '-' }}</div>
                    </div>

                    <div class="item">
                        <div class="key">Shipping</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->delivery_price ? $item->delivery_price . ' USD' : '-' }}</div>
                    </div>

                    <div class="item">
                        <div class="key">Total</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->total_price ? $item->total_price . ' USD' : '-' }}</div>
                    </div>
                    @if($item->parcel->count())
                        <div class="cell">{{ $item->parcel->first()->name }}</div>
                    @endif
                </div>

            </div>
            <div class="receiver">
                <div class="rec_title">RECEIVER</div>
                <div class="title">{{ $item->user->full_name }}
                    <div class="sub-title">{{ $item->user->passport }} ({{ $item->user->fin }})</div>
                </div>
                <div class="items">
                    <div class="item">
                        <div class="key">Personal ID</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->user->customer_id }}</div>
                    </div>

                    <div class="item">
                        <div class="key">Mobile</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->user->cleared_phone }}</div>
                    </div>

                    <div class="item">
                        <div class="key">Address</div>
                        <div class="dot">:</div>
                        <div class="value" style="position: relative; top: 10px">{{ $item->user->address }}</div>
                    </div>

                    <div class="item" style="margin-top: 10px">
                        <div class="key">Country</div>
                        <div class="dot">:</div>
                        <div class="value">Azerbaijan</div>
                    </div>
                    <div class="item">
                        <div class="key">Filial</div>
                        <div class="dot">:</div>
                        <div class="value">{{ $item->user->filial_name }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tracking_code">
            @if ($item->tracking_code)
                <img src="http://barcode.tec-it.com/barcode.ashx?data={{ $item->custom_id }}&code=Code128&dpi=600&dataseparator="
                     alt="">
            @endif
        </div>
    </div>
</main>

</body>
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

</html>