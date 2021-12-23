@if(isset($package))
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter{{ $package->id }}" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <strong>{{ __('front.user_packages.order_number') }}</strong>
                            <br>{{ $package->custom_id }}</div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <strong>{{ __('front.user_packages.order_date') }}</strong>
                            <br>{{ $package->created_at->format('d.m.y') }}</div>
                        <div class="col-md-4 col-sm-6 col-xs-12"><strong>{{ __('front.user_packages.store') }}</strong>
                            <br>{{ $package->website_name }}</div>

                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <img style="filter: none" src="{{ asset('front/img/tracking/ordered.svg') }}" alt="">
                            <p class="modal-text"
                               style="margin-left: -5px">{{ __('additional.tracking_modal.ordered') }}
                            </p>
                        </div>
                        <div class="col next-step">
                            <img src="{{ asset('front/img/tracking/next.svg') }}" alt="">
                        </div>
                        <div class="col">
                            @if($package->status >= 0  && $package->status != 6)
                                <img style="" src="{{ asset('front/img/tracking/warehouse.svg') }}" alt="">
                            @else
                                <img class="gray-filter"
                                     src="{{ asset('front/img/tracking/warehouse.svg') }}" alt="">
                            @endif
                            <p class="modal-text"
                               style="margin-left: -10px">{{ __('additional.tracking_modal.warehouse') }}
                            </p>
                        </div>
                        <div class="col next-step">
                            @if($package->status > 0 && $package->status != 6)
                                <img src="{{ asset('front/img/tracking/next.svg') }}" alt="">
                            @else
                                <img class="gray-filter" src="{{ asset('front/img/tracking/next.svg') }}"
                                     alt="">
                            @endif
                        </div>
                        <div class="col">
                            @if($package->status > 0 && $package->status != 6)
                                <img src="{{ asset('front/img/tracking/sent.svg') }}" alt="">
                            @else
                                <img class="gray-filter" src="{{ asset('front/img/tracking/sent.svg') }}"
                                     alt="">
                            @endif
                            <p class="modal-text" style="margin-left: -15px">{{ __('additional.tracking_modal.sent') }}
                            </p>
                        </div>
                        <div class="col next-step">
                            @if($package->status > 1 && $package->status != 6)
                                <img src="{{ asset('front/img/tracking/next.svg') }}" alt="">
                            @else
                                <img class="gray-filter" src="{{ asset('front/img/tracking/next.svg') }}"
                                     alt="">
                            @endif
                        </div>
                        <div class="col">
                            @if($package->status > 1 && $package->status != 6)
                                <img src="{{ asset('front/img/tracking/delivered.svg') }}" alt="">
                            @else
                                <img class="gray-filter"
                                     src="{{ asset('front/img/tracking/delivered.svg') }}" alt="">
                            @endif
                            <p class="modal-text" style="margin-left: -5px">
                                {{ __('additional.tracking_modal.delivered') }}
                            </p>
                        </div>
                        <div class="col next-step">
                            @if($package->status == 3 && $package->status != 6)
                                <img src="{{ asset('front/img/tracking/next.svg') }}" alt="">
                            @else
                                <img class="gray-filter" src="{{ asset('front/img/tracking/next.svg') }}"
                                     alt="">
                            @endif
                        </div>
                        <div class="col">
                            @if($package->status == 3 && $package->status != 6)
                                <img src="{{ asset('front/img/tracking/done.svg') }}" alt="">
                            @else
                                <img style="filter: grayscale(100%);"
                                     src="{{ asset('front/img/tracking/done.svg') }}" alt="">
                            @endif
                            <p class="modal-text" style="margin-left: -25px">
                                {{ __('additional.tracking_modal.done') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('css')
    <style>
        .bd-example-modal-lg {
            margin-top: 15%
        }

        .modal-body {
            padding: 30px 50px;
        }

        .modal-body img {
            max-width: 50px;
        }

        .modal-text {
            margin-top: 4px;
            font-weight: 600;
        }

        .next-step img {
            max-width: 40px;
            margin: 10px 0 0 0;
        }

        .gray-filter {
            filter: grayscale(100%);
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).on('show.bs.modal', '.modal', function () {
            $(this).appendTo('body');
        });
    </script>
@endpush

