<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Label # {{ $item->id }}">
    <meta name="author" content="ASE">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label # {{ $item->id }}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
    <style>

        .container {
            max-width: 850px !important;
            min-width: 500px !important;
        }

        html, body {
            height: 100%;
            width: 100%;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
            overflow: hidden !important;
            size: auto;  margin: 0mm;
            height: 100%;
            width: 100%;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
        }

        main {
            width: 850px;
            height: 550px;
            font-size: 1em;
            line-height: 1.6em;
            margin: 15px 0 0 15px;

        }

        #table-right-footer {
            padding: 15px 5px;
        }

        @page {
            size: auto;
            margin: 0mm;
        }

        @media print {

            .print {
                display: none !important;
            }


            main {
                /*transform: rotate(-90deg);
                left: -285px;
                bottom: 220px;*/
            }
        }

        .print {
            display: block;
            float: right;
            border: 1px solid #000;
            margin-right: 21px;
            padding: 15px;
            border-radius: 6px;
            font-weight: 600;
            background: #f1f1f1;
            cursor: pointer;
            position: absolute;
            right: 0px;
            top: 24px;
        }

        .rotated {
            margin: 1px auto;
            /*transform: rotate(90deg);*/
        }

        .table-left {
            width: 41%;
            border-right: 1px solid #000;
        }

        .line {
            height: 2px;
            background: #000000;
            width: 100%;
            display: block;
            margin-left: 0;
            border: 1px solid #000000;
        }

        #table-left-header {
            height: 135px;
        }

        #table-left-header img {
            margin-top: 2px;
            margin-bottom: 2px;
            width: 100%;
            height: 100px;

        }

        #table-left-recipient {
            padding-top: 10px;
        }

        #table-left-recipient img {
            width: 100%;
            height: auto;
        }

        .table-right {
            width: 58%;
        }

        #table-right-header {
            padding-top: 10px;
        }

        #table-right-barcode img {
            width: 100%;
            height: 130px;
            padding-bottom: 10px;
        }

        .cold-6 {
            position: relative;
            left: 54.5%;
        }

        .cold-5 {
            position: relative;
            left: 58.5%;
        }

        .cold-7 {
            position: relative;
            left: 44.5%;
        }

        .cold-12 {
            position: relative;
            top: 10.5%;
        }

        .borderly {
            border-bottom: 1px solid black;
            height: 570px;
            position: absolute;
            padding: 25px 10px 10px 10px;
        }

    </style>

</head>

<body>

<main>
    <div class="container borderly" style="width: 1200px;">
        <div class="row">
            <div class="col-5 table-left">
                <div id="table-left-header">
                    <div class="row" style="">
                        <div class="col-6">
                            <img src="{{ asset('admin/images/logo_cert.jpg') }}"
                                 alt="">
                        </div>
                        <div class="col-6 cold-6">
                            <div style="padding-top: 25px">INTERNATIONAL AIRWAY BILL</div>
                        </div>
                    </div>
                </div>
                <div class="line"></div>
                <div id="table-left-shipper">
                    <div class="row">
                        <div class="col-12">
                            @if($shipper)
                                <p><b>SHIPPER:</b> {{ $shipper->address->phone or '-' }}</p>
                                <p class="ml-2">{{ $item->website_name }} <br>
                                    @if ($shipper)
                                        @if($item->fake_address)
                                            {{ $item->fake_address }}<br>
                                        @else
                                            {{ $shipper->company_name or '-' }} <br>
                                            {{ $shipper->address->address_line_1 or '-' }} <br>
                                        @endif
                                        {{ $shipper->address->city or null }}
                                        , {{ $shipper->address->state or null }} {{ $shipper->address->zip_code or null }}
                                        <br>
                                        {{ $shipper->country->translateOrDefault('en')->name or '-' }}
                                    @endif
                                </p>
                            @endif
                        </div>
                        {{--<div class="col-4">
                            <p><b>ORIGIN:</b><br>
                                SBR - JFK</p>
                        </div>--}}
                    </div>
                </div>
                <div class="line"></div>
                <div id="table-left-recipient">
                    <div class="row">
                        <div class="col-12">
                            <p><b>RECIPIENT:</b> <i>{{ $item->user ? $item->user->full_name : '-' }}</i> <br></p>
                            <p class="ml-2">
                                <b>Address</b> : <i>{{ $item->user ? $item->user->address : '-' }}</i><br>
                                <b>Phone</b> : <i>{{ $item->user ? $item->user->phone : '-' }}</i><br>
                                <b>Passport</b> : <i>{{ $item->user ? $item->user->passport : '-' }}</i><br>
                                <b>Fin </b>: <i>{{ $item->user ? $item->user->fin : '-' }}</i><br>
                            </p>
                            <p class="ml-2" style="font-size: 18px;margin-top: -7px;margin-bottom: 6px;">
                                Azerbaijan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7 cold-7 table-right">
                <div id="table-right-header">
                    <div class="row">
                        <div class="col-7">
                            <div><b>Ship Date:</b> <i>{{ $item->updated_at or '-' }}</i> <br>
                                <b>Actl Wght: </b> <i>{{ $item->weight_with_type or '-' }}</i> <br>
                                <b>Acc #:</b> <i>{{ $item->user ? $item->user->customer_id : '-' }}</i> <br>
                            </div>
                        </div>
                        <div class="col-5 cold-5">
                            <p>
                                <b>Qty:</b> <i>1 pc</i> <br/>
                                <b>Dims:</b> <i>[{{ $item->width ? $item->full_size : '-' }}]</i>
                            </p>
                        </div>
                        <div class="col-12 cold-12">
                            <p>
                                <b>REF #:</b> <i>{{ $item->tracking_code }}</i>
                            </p>
                        </div>
                    </div>
                    <div class="line" style="position: relative; top: -60px"></div>


                </div>
                <div class="pt-2" id="table-right-barcode" style="position: relative; top: -40px">
                    @if ($item->tracking_code)
                        <img src="http://barcode.tec-it.com/barcode.ashx?data={{ $item->custom_id }}&code=Code128&dpi=400&dataseparator="
                             alt="">
                    @endif
                </div>

                <div id="table-right-footer" style="height: 170px; position: relative; top: -10px">
                    <div class="row">
                        <div class="col-5">
                            <p>
                                <b>Shipping Bill To:</b> <br>
                                <b>Taxes Bill To: </b><br>
                                <b>Invoice Value: </b><br>
                                <b>Delivery Value: </b><br>
                                <b>Total Declared Value: </b><br>
                                <b>Value Protection: </b><br>
                                <b>Contents: </b><br>
                            </p>
                        </div>
                        <div class="col-7 cold-7">
                            <p>
                                <i>3RD PARTY</i><br>
                                <i>3RD PARTY</i><br>
                                <i>{{ $item->shipping_price ? $item->shipping_price : '-' }}</i><br>
                                <i>{{ $item->delivery_price ? $item->delivery_price . ' USD' : '-' }}</i><br>
                                <i>{{ $item->total_price ? $item->total_price . ' USD' : '-' }}</i><br>
                                <i>Std</i><br/>
                                <i><?= $item->detailed_type . ($item->other_type ? "(" . $item->other_type .")" : null) ?></i></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
</body>
</html>