<div class="col-lg-3 col-md-4 col-sm-12 form-group message-btn accordion_inbutton">
    <form action="{{ trim($action_adr) }}" method="POST" id="portmanat_payment_form">
        <button type='submit' class="theme-btn-one">{{ __('front.user_orders.pay_button') }}<i
                    class="icon-Arrow-Right"></i></button>

        {!! implode("\n", $args_array) !!}
    </form>
</div>