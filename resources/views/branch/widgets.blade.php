<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="row ">
            @foreach($widgets as $widget)
                <div class="col-xl-3 col-lg-6">
                    <div class="card {{$widget->class}}">
                        <div class="card-statistic p-4">
                            <div class="card-icon card-icon-large"><i class="{{$widget->icon}}"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">{{$widget->title}}</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        {{$widget->count}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('css')
    <style>
        .card {
            background-color: #fff;
            border-radius: 10px;
            border: none;
            position: relative;
            margin-bottom: 30px;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
        }
        .l-bg-cherry {
            background: linear-gradient(to right, #493240, #f09) !important;
            color: #fff;
        }

        .l-bg-blue-dark {
            background: linear-gradient(to right, #373b44, #4286f4) !important;
            color: #fff;
        }

        .l-bg-green-dark {
            background: linear-gradient(to right, #0a504a, #38ef7d) !important;
            color: #fff;
        }

        .l-bg-orange-dark {
            background: linear-gradient(to right, #a86008, #ffba56) !important;
            color: #fff;
        }

        .card .card-statistic .card-icon-large .fas, .card .card-statistic .card-icon-large .far, .card .card-statistic .card-icon-large .fab, .card .card-statistic .card-icon-large .fal {
            font-size: 110px;
        }

        .card {
            overflow: hidden;
        }

        .card .card-statistic .card-icon {
            text-align: center;
            line-height: 50px;
            margin-left: 10px;
            color: #000;
            position: absolute;
            right: 5px;
            top: 20px;
            opacity: 0.1;
        }
    </style>
@endpush