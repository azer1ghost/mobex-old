@extends('front.layout')

@section('content')
    <section class="section pt-200">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-3 bottom-100 bottom-lg-0">
                </div>
                <div class="col-md-6 col-lg-6 bottom-100 bottom-lg-0">
                    <form class="form" action="javascript:void(0);" autocomplete="off">
                        <h5 class="bottom-30">Email təsdiqi</h5>
                        <div class="row">
                            <div class="col-12">
                                <input class="form__field" type="sms" name="sms" placeholder="SMS kod"/>
                            </div>
                            <div class="col-12 bottom-30"><span class="form__text"><a href="#">SMS gəlmədi?</a></span>
                            </div>
                            <div class="col-12">
                                <button class="button button--green" type="submit"><span>Təsdiq et</span>
                                    <svg class="icon">
                                        <use xlink:href="#arrow"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 col-lg-3 bottom-100">

                </div>
            </div>
        </div>
    </section>
@endsection