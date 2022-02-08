@extends('front.layout')

@section('content')
    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    <div class="declare_box add-listing full">
                        <div class="row single-box">
                            <div class="inner-box">
                                <div class="alert alert--attention alert--filled">
                                    <p class="alert__text">Tredyol doğrulama kodu</p>
                                </div>
                                <ul class="list-group" id="codeList" x-data="trendyolVerifyApi" @click="getCodes">
                                    <li class="py-4">
                                        Aşağıda bir neçə kod görünə bilər. Hər birini yoxlayır
                                    </li>
                                    <template x-for="code in codes" :key="code">
                                        <li class="list-group-item" x-text="code"></li>
                                    </template>
                                    <li x-show="!codes.length" class="list-group-item">Hazırda doğrulama kodu mövcud deyil</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function trendyolVerifyApi(){
            return {
                codes: [],
                timer: null,
                getCodes(){
                  fetch('{{route('my-trendyol.get')}}')
                      .then(res => res.json())
                      .then(data => {
                          this.codes = data;
                      });
                },
            }
        }
        setInterval(function () {document.getElementById("codeList").click();}, 1000);
    </script>
@endpush




