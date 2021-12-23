@extends('front.layout')

@section('content')
    <div class="my-packages">
        <!-- content start -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="wrapper-content bg-white pinside30">

                        <div class="row mb40">
                            <div class="col-lg-9 col-sm-12">
                                <h1 class="mb20">{{ __('front.order_page_title') }}</h1>
                                <p>{!! __('front.order_page_description') !!}</p>
                            </div>
                            <div class="col-lg-3 col-sm-12 text-right">
                                <a href="{{ route('my-orders.create') }}"
                                   class="btn btn-default">{{ __('front.order') }}</a>
                            </div>
                        </div>

                        @if (session('deleted'))
                            <div class="alert alert-danger"
                                 role="alert">{{ __('front.order_was_deleted') }}</div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success"
                                 role="alert">{{ __('front.order_was_created') }}</div>
                        @endif
                        @forelse($orders as $order)
                            @if($order->country)
                                <div class="compare-block mb30">
                                    <div class="compare-title bg-primary pinside20">
                                        <span class="date">{{ $order->created_at->format('d.m.y') }}</span>
                                        <span class="label label-{{ $order->status_info['label'] }}">{{ $order->status_info['text'] }}</span>
                                    </div>
                                    <div class="compare-row outline pinside30">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <img class="web_logo"
                                                     src="{{ $order->country ? $order->country->flag : null }}"
                                                     alt="{{ $order->country ? $order->country->name : null }}">
                                                <div class="shipping_price">{{ $order->country ? $order->country->translateOrDefault($_lang)->name : "-" }}</div>
                                            </div>
                                            <div class="col-md-2 col-sm-6 col-xs-12">
                                                <div class="text-center">
                                                    <h3 class="rate">{{ $order->links_count }}</h3>
                                                    <small>{{ __('front.number_links') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-6 col-xs-12">
                                                <div class="text-center">
                                                    <h3 class="repayment">{{ $order->service_fee or '-' }}</h3>
                                                    <small>{{ __('front.service_fee') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-6 col-xs-12">
                                                <div class="text-center">
                                                    <h3 class="compare-rate">{{ $order->total_price or '-' }}</h3>
                                                    <small>{{ __('front.total_price') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="text-center compare-action">
                                                    @if(! $order->status)
                                                        {!! Form::open(['id' => 'order_' . $order->id, 'method' => 'delete', 'route' => ['my-orders.delete', $order->id]]) !!}
                                                        {!! Form::close() !!}
                                                        <a onclick="document.getElementById('order_<?= $order->id; ?>').submit();"
                                                           class="btn btn-danger btn-sm">{{ __('front.delete') }}</a>
                                                    @endif
                                                    <a href="{{ route('my-orders.show', $order->id) }}"
                                                       class="btn btn-primary btn-sm">{{ __('front.detailed') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="alert alert-warning"
                                 role="alert">{{ __('front.no_any_package') }}</div>
                        @endforelse
                        <div class="mt-20 text-center">
                            {!! $orders->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection