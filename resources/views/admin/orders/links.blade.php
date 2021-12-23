@extends(config('saysay.crud.layout'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Links for request</span>
                            #{{ $order->id }}</h4>
                        <a class="heading-elements-toggle"><i class="icon-more"></i></a></div>
                </div>
                <div class="breadcrumb-line breadcrumb-line-component"><a class="breadcrumb-elements-toggle"><i
                                class="icon-menu-open"></i></a>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Dashboard</a>
                        </li>
                        <li><a href="{{ route('orders.index') }}">Requests</a></li>
                        <li class="active">Request #{{ $order->id }}</li>
                    </ul>
                </div>
            </div>
            <div class="content">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Links</h5>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <ul>
                                    @if(isset($order->country->warehouse->address))
                                        <li><b>Name</b> : <i style="color: #2162ff">{{ $order->user->full_name }}</i>
                                        </li>
                                        <li><b>Balance</b> : <i
                                                    style="color: #2162ff">{{ $order->user->order_balance }}</i></li>
                                        <li><b>Member ID</b> : <i
                                                    style="color: #2162ff">{{ $order->user->customer_id }} </i></li>
                                        <li><b>Country</b> : <i style="color: #2162ff">{{ $order->country->name }} </i>
                                        </li>
                                        <li><b>Address</b> : <i
                                                    style="color: #2162ff">{{ $order->user->customer_id }} {{ $order->country->warehouse->address->address_line_1 }} </i>
                                        </li>
                                        <li>

                                        </li>
                                        <li>

                                        </li>
                                        <li><b>Phone</b> : <i
                                                    style="color: #2162ff"><a target="_blank"
                                                                              href="https://wa.me/{{ $order->user->cleared_phone }}?text=Salam {{ $order->user->full_name }}">+{{ $order->user->cleared_phone }} </a>
                                            </i></li>
                                        <li><b>Email</b> : <i
                                                    style="color: #2162ff"><a
                                                        href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                                            </i></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-lg-2">
                                <ul>
                                    <li><b>Price</b> : <i>{{ $order->price }} TL</i></li>
                                    <li><b>Service Fee</b> : <i>{{ $order->service_fee }} TL</i></li>
                                    <li><b>Total</b> : <i>{{ $order->total_price }} TL</i></li>
                                </ul>
                                <a id="declare-order" target="_blank"
                                   href="{{ route('packages.create') }}?user_id={{ $order->user_id }}&number_items={{ $order->links()->sum('amount') }}&warehouse_id={{ $order->country->warehouse->id }}&order_id={{ $order->id }}&type_id=108&website_name={{ getOnlyDomainWithExt($order->links->first()->url) }}&shipping_amount={{ $order->admin_paid }}&links={{ implode(",", $order->links()->pluck('id')->all()) }}"
                                   data-url="{{ route('packages.create') }}?user_id={{ $order->user_id }}&number_items=:items&warehouse_id={{ $order->country->warehouse->id }}&links=:links&type_id=108&website_name=:domain&shipping_amount=:price"
                                   style="margin-top: 20px;margin-left: 25px;"
                                   class="btn btn-danger legitRipple">Declare</a>
                            </div>

                            <div class="col-lg-5">
                                {!! Form::open(['method' => 'PUT','route' =>['orders.custom', $order->id]]) !!}
                                @if($listFields)
                                    @foreach ($listFields as $field)
                                        @include('crud::fields.' . $field['type'], ['field' => $field])
                                    @endforeach
                                @else
                                    @include('crud::components.alert', ['text' => trans('saysay::crud.no_fields')])
                                @endif
                                <button style="margin-top: 20px;margin-left: 25px;" type="submit"
                                        class="btn btn-info legitRipple">{{ trans('saysay::crud.save') }}</button>
                                {!! Form::close() !!}
                            </div>

                        </div>

                        @if ($order->note) User note : {{ $order->note }} @endif
                    </div>


                    <div class="table-responsive" style="margin-top: 40px">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>

                                </th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Cargo</th>
                                <th>Note</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($links as $row => $item)
                                <tr>
                                    <td>
                                        <input checked title="check" type="checkbox" class="styled check_all"
                                               name="items[]" data-amount="{{ $item->amount }}"
                                               data-website="{{ getOnlyDomainWithExt($item->url) }}"
                                               data-price="{{ $item->price + $item->cargo_fee }}"
                                               value="{{ $item->id }}"/>
                                    </td>
                                    <td><a target="_blank"
                                           href="https://bon.az/r?id={{ env('BONAZ_ID') }}&order_id={{ $order->id }}&url={{ $item->url }}">{{ str_limit($item->url, (strlen($item->url) > 60 ? 60 : (strlen($item->url) - 3))) }}</a>
                                    </td>
                                    <td>@include('crud::components.columns.select-editable', ['entry' => $item->status])</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->color }}</td>
                                    <td>{{ $item->size }}</td>
                                    <td>{{ $item->price }}TL</td>
                                    <td>{{ $item->cargo_fee }}TL</td>
                                    <td>{{ $item->note }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            let declare = $("#declare-order");

            $('input[type="checkbox"]').click(function () {
                let amount = 0;
                let webSite = null;
                let totalPrice = null;
                let items = "";
                $('.check_all:checkbox:checked').each(function () {

                    webSite = $(this).data("website");
                    totalPrice = totalPrice + parseFloat($(this).data("price"));
                    items = $(this).val() + "," + items;
                    amount += parseInt($(this).data("amount"))
                });

                url = declare.data('url');
                url = url.replace(":domain", webSite);
                url = url.replace(":items", amount);
                url = url.replace(":price", totalPrice);
                url = url.replace(":links", items);
                declare.attr("href", url);
                declare.fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);

            });
        });
    </script>
@endpush