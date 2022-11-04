@extends('front.layout')

@section('content')
    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    @include('front.user.sections.balances')
                    <div class="declare_box add-listing full">
                        <div class="row single-box">
                            <!-- dashboard link slider -->
                            <div class="inner-box d-flex">
                                <section class="balans_section full-size">
                                    <div class="balans_section_ba full">
                                        <h2>{{ __('front.balance.title') }}</h2>
                                        @if (request()->get('success') != null)
                                            <div class="alert alert-success"
                                                 role="alert">Promo kodunuz əlavə edildi
                                            </div>
                                        @endif
                                        @if (request()->get('error') != null)
                                            <div class="alert alert-success"
                                                 role="alert">Promo əlavə edilmədi
                                            </div>
                                        @endif
                                        <div class="ba_container full">
                                            <ul class="ba_list">
                                                <li>
                                                    <p class="ba_name">{{ __('front.panel_header.order_balance') }}</p>
                                                    <p class="ba_balance">{{ auth()->user()->orderBalance(true) }}</p>
                                                    <div class="ba_button">
                                                        {!! Form::open(['method' => 'get', 'route' => 'deposit']) !!}
                                                        <div class="form-group">
                                                            <input name="amount" value="100" class="form__field"
                                                                   type="text">
                                                        </div>
                                                        <button type="submit"
                                                                class="theme-btn-one">{{ __('front.enter_balance') }}<i
                                                                    class="icon-Arrow-Right"></i></button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </li>
                                                <li>
                                                    <p class="ba_name">{{ __('front.panel_header.package_balance') }}</p>
                                                    <p class="ba_balance">{{ auth()->user()->packageBalance(true) }}</p>
                                                </li>
{{--                                                <li>--}}
{{--                                                    <p class="ba_name">Promo</p>--}}
{{--                                                    <p class="ba_balance">&nbsp;</p>--}}
{{--                                                    <div class="ba_button">--}}
{{--                                                        {!! Form::open(['method' => 'post']) !!}--}}
{{--                                                        <div class="form-group" style="width: 160px">--}}
{{--                                                            <input placeholder="Promo kod" name="promo"--}}
{{--                                                                   class="form__field" type="text">--}}
{{--                                                        </div>--}}
{{--                                                        <button type="submit"--}}
{{--                                                                class="theme-btn-one">İstifadə et<i--}}
{{--                                                                    class="icon-Arrow-Right"></i></button>--}}
{{--                                                        {!! Form::close() !!}--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
                                            </ul>
                                            <p class="ba_note">{{ __('front.balance.note') }}</p>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="row" style="background-color: #F7F7F8;padding: 40px;border: 1px solid #fe9107;border-radius: 10px;margin-bottom: 30px; margin-top: -10px">
                            <div class="col-lg-8">
                                <h3>E-Manat üzərindən balansınızı artırın</h3>
                                <p style="padding: 30px 0;">E-manat terminalları vasitəsilə balansınızı artıra bilərsiniz. Bunun üçün E-manat terminalına yaxınlaşırsınız, 'digər' bölməsinə daxil olaraq 'Mobex'-i seçirsiniz. <b>'{{ str_replace(env('MEMBER_PREFIX_CODE'), "", auth()->user()->customer_id) }}'</b> müştəri kodunuzu yığaraq 'davam et' düyməsini sıxırsınız. Hansı balansı artırmaq istəyirsizsə seçdikdən sonra istədiyiniz məbləği daxil edib təsdiq edirsiniz. Əməliyyatı bitirdikdən sonra pul dərhal şəxsi kabinetdəki balansınızda görünəcək.</p>
                                <div><strong>Qeyd: Çatdırılma balansı ilə Türkiyədən alış-veriş etmək mümkün deyil! AZN balansından TRY balansına pul transferi mümkün deyil!</strong></div>
                            </div>
                            <div class="col-lg-4 hidden-sm hidden-xs">
                                <img src="{{ asset('assets/images/emanat.jpeg') }}"/>
                            </div>
                        </div>
                        <div class="row single-box">
                            <div class="inner-box d-flex">
                                <section class="cashin_table doctors-appointment  full-size">
                                    <div class="table-outer">
                                        <table class="doctors-table">
                                            <thead class="table-header">
                                            <tr>
                                                <th>{{ __('front.balance.table.sub_1') }}</th>
                                                <th class="tr_bold">{{ __('front.balance.table.sub_2') }}</th>
                                                <th>{{ __('front.balance.table.sub_3') }}</th>
                                                <th>{{ __('front.balance.table.sub_4') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($transactions as $transaction)
                                                <tr>

                                                    <td>
                                                        <p> {{ $transaction->created_at->format('M d,Y h:i') }}</p>
                                                    </td>
                                                    <td class="tr_bold">
                                                        <p>{{ $transaction->getPrefixAttribute(true) . $transaction->amount . " " . $transaction->currency }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $transaction->paid_for }}</p>
                                                    </td>
                                                    <td class="tr_bold">
                                                        <p>{{ $transaction->paid_by }}</p>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>

                                                    <td colspan="4">
                                                        <strong class="error-text">{{ __('additional.no_data_found') }}</strong>
                                                    </td>

                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                                <div class="pagination-wrapper centred">
                                    @include('front.widgets.pagination', ['paginator' => $transactions])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection