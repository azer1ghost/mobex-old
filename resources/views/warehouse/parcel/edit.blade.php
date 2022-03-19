@extends(config('saysay.crud.layout'))

@section('content')
    <div class="row">
        {!! Form::open(['route' => [$crud['route'] . '.update', $parcel->id], 'method' => 'put', 'id' => 'package_ids']) !!}
        <div class="col-lg-12 col-lg-offset-0 col-md-12 col-xs-12">
            <div class="panel panel-flat">
                <div class="panel-heading" style="margin-bottom: 30px;">
                    <div class="row">

{{--                        @if(auth('worker')->user()->getAttribute('warehouse_id') == 1)--}}
{{--                        <div class="col-12 m-5 p-5 text-white">--}}
{{--                            <table>--}}
{{--                                <tbody>--}}
{{--                                <tr>--}}
{{--                                    <td style="background-color: #5e95e8">--}}
{{--                                        <p style="padding: 10px">Nizami</p>--}}
{{--                                    </td>--}}
{{--                                    <td style="background-color: #e0874e">--}}
{{--                                        <p style="padding: 10px">Həzi</p>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                        @endif--}}

                        <div class="col-lg-4">
                            <div>
                                <label>Parcel name</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="icon-barcode2"></i></div>
                                    <input id="name" type="text" name="name" value="{{ $parcel->custom_id }}"
                                           class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label>AirWayBill number</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="icon-barcode2"></i></div>
                                    <input id="name" type="text" name="awb" value="{{ $parcel->awb }}"
                                           class="form-control">
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="heading-elements">
                        @if ($parcel->sent == 0)

                            <span style="position: relative; top: 2px;margin-right: 20px; border: 1px solid #ff1c90; padding: 10px; border-radius: 5px">Packages : <a
                                        href="#!"
                                        id="waiting_packages" class="waiting_packages"
                                        style="background: red;color: #fff;padding: 5px;border-radius: 5px;">{{ $parcel->packages->count() }} / {{ $parcel->packages->sum('weight') }}kq</a></span>
                        @else
                            <span style="position: relative; top: 2px;margin-right: 20px; border: 1px solid #ff1c90; padding: 10px; border-radius: 5px">Use <b>SHIFT+ENTER</b> to add new package</span>
                            <button type="button" data-toggle="modal" data-target="#new_package"
                                    class="btn btn-primary btn-icon" style="margin-right: 28px;">ADD
                            </button>
                        @endif
                        <button type="submit" id="export-packages" class="btn btn-info btn-sm legitRipple">
                            <i class="icon-check position-left"></i>
                            Done
                            <span class="legitRipple-ripple"></span></button>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="table-responsive overflow-visible">
                        <table class="table table-hover responsive table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                @foreach($_list as $key => $head)
                                    <th>{{ is_array($head) ? (array_key_exists('label', $head) ? $head['label'] : ucfirst(str_replace("_", " ", $key))) : ucfirst(str_replace("_", " ", $head)) }}</th>
                                @endforeach
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="scanned" data-id="{{ $parcel->id }}">
                            @foreach($parcel->packages as $citem)
                                @include('warehouse.widgets.single-package', ['item' => $citem, 'extraActions' => $extraActionsForPackage])
                            @endforeach
                            <tr style="display: none" id="empty_package">
                                <td colspan="{{ count($_list) + 2 }}">
                                    <div class="alert alert-danger">Please scan or add a package(s)</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="panel-heading" style="height: 150px; border-top: 1px solid #ccc;">
                    <div class="heading-delements">

                        {!! Form::open(['id' => 'manual_add_package', 'class' => 'no_loading']) !!}
                        <div class="col-md-6">
                            <label>Tracking Number or CWB</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="icon-truck"></i></div>
                                <input required id="manual_add" type="text" name="manual_add" value=""
                                       class="form-control">
                            </div>
                            <p class="help-block">If you want add a package manually</p>

                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-icon" style="margin-top: 28px;"><i
                                        class="icon-plus2"></i></button>
                        </div>
                        <div class="col-md-4">
                            @if ($parcel->sent == 0)
                                <span style="position: relative; top: 35px;margin-right: 20px; border: 1px solid #ff1c90; padding: 10px; border-radius: 5px">Packages : <a
                                            href="#!"
                                            id="waiting_packages" class="waiting_packages"
                                            style="background: red;color: #fff;padding: 5px;border-radius: 5px;">{{ $parcel->packages->count() }} / {{ $parcel->packages->sum('weight') }}kq</a></span>
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="modal" role="dialog" id="new_package">
        <div class="modal-dialog" role="document" style="width: 1100px">
            <div class="modal-content">
                <span id="delivery_index" data-value="{{  auth()->guard('worker')->user()->warehouse->country->delivery_index }}"></span>
                {{ Form::open(['url' => route('w-parcel.add_package', $parcel->id), 'class' => 'no_loading','method' => 'post', 'id' => 'form_add_package', 'files' => true]) }}
                <div class="modal-header">
                    <h5 class="modal-title">Add new package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 style="line-height: 50px; font-size: 20px;height: 50px; background-color: #c3eee4" class="text-center text-white" id="filial-indicator">
                        Filial
                    </h3>
                    <h3 style="line-height: 20px; font-size: 18px;height: 20px; background-color: #ec4f53;display: none" class="text-center text-white" id="order-indicator">
                        Diqqət! Bağlamanın erkən bəyanı ola bilər.
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @if($fields)
                            @foreach ($fields as $field)
                                @if(auth()->guard('worker')->user()->warehouse->allow_make_fake_invoice || (! auth()->guard('worker')->user()->warehouse->allow_make_fake_invoice && auth()->guard('worker')->user()->warehouse->only_weight_input && isset($field['short'])))
                                    @include('crud::fields.' . $field['type'], ['field' => $field])
                                @endif
                            @endforeach
                        @else
                            @include('crud::components.alert', ['text' => trans('saysay::crud.no_fields')])
                        @endif
                    </div>
                    <div id="alert_price" style="display: none" class="alert alert-danger">Price is over 900. Be sure
                        that the price is correct.
                    </div>
                    <div id="alert_weight" style="display: none" class="alert alert-danger">Weight is over 9kq. Be sure
                        that the weight is correct.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Package</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <div id="user_packages" style="display: none" data-route="{{ route('w-user.packages') }}">
                        <div class="table-responsive overflow-visible">
                            <table class="table table-hover responsive table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tracking #</th>
                                    <th>Invoice</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="body_packages">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <iframe id="ifrPaySlip"  name="ifrPaySlip" scrolling="yes" style="display:none"></iframe>
@endsection

@push('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>

        // function getRandomIntInclusive(min = 8, max = 55) {
        //     min = Math.ceil(min);
        //     max = Math.floor(max);
        //     return Math.floor(Math.random() * (max - min + 1) + min);
        // }

        // Fake qiymet kodu yalniz amerika ucun
{{--        @if(auth('worker')->user()->getAttribute('warehouse_id') == 6)--}}
{{--            $('#new_package').on('shown.bs.modal', function () {--}}
{{--                $('input[name=shipping_amount]').val(getRandomIntInclusive());--}}
{{--            })--}}
{{--        @endif--}}

        @if(auth('worker')->user()->getAttribute('warehouse_id') == 1)
            // cesidleme kodlari - yalniz UMT
            $('#manual_add_package').submit(function (){
                $('#filial-indicator').css("background-color", "#c3eee4").text('Filial')
                $("#order-indicator").hide()
            })

            $('.icon-plus2').click(function (){
                $('#filial-indicator').css("background-color", "#c3eee4").text('Filial')
                $("#order-indicator").hide()
            })

            $('select').on('select2:select', function (e) {
                var data = e.params.data;
                $("select option[value=" + data.id + "]").data('filial', data.filial);
                $("select").trigger('change');


                if(data.has_last_orders){
                    $("#order-indicator").show()
                } else {
                    $("#order-indicator").hide()
                }


                var indicator = $('#filial-indicator')

                switch (data.filial) {
                    case 4:
                        indicator.css("background-color", "#5e95e8").text('Nizami Filiali')
                        break;
                    case 6:
                        indicator.css("background-color", "#e0874e").text('Hezi Filiali')
                        break;
                    default:
                        indicator.css("background-color", "#c3eee4").text('Filial')
                }
            });
            // cesidleme kodlari burda bitdi
        @endif

        $.validate();
        $(document).ready(function () {
            $("input[name='name'], input[name='awb']").on("keyup", function () {
                parent = $(this).parents('form');
                $.post(parent.attr('action'), parent.serialize())
            });
        });
    </script>
@endpush