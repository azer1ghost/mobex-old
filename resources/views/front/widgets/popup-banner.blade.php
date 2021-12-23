<?php
$banner = App\Models\Slider::where('alert', true)->where('active', true)->latest()->first();
?>
@if($banner && auth()->check())
    <div class='modal fade' id='banner_show' data-backdrop="static" data-keyboard="false">
        <div class='modal-dialog' style="width: 80%; position: fixed;top:50%;left:50%;transform: translate(-50%, -50%);">
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title'>
                        <strong>{!! $banner->title !!}</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class='modal-body'>
                    {!! $banner->content !!}
                </div>

                <div class="modal-footer">
                    @if($banner->url)
                        <a id="click_modal" href="{{ $banner->url }}" type="button"
                           class="btn btn-primary mr-auto">{{ $banner->button_label }}</a>
                    @endif
                </div>

            </div>

        </div>
    </div>

    @push('js')
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script>
            $(document).ready(function () {
                var cookie_name = 'cookie_name_<?= $banner->id?>';
                var my_cookie = $.cookie(cookie_name);
                bs = $('#banner_show');
                if (my_cookie && my_cookie == "true") {
                    console.log("Don't sent");
                } else {
                    bs.modal('show');
                }

                bs.on('hidden.bs.modal', function () {
                    $.cookie(cookie_name, 'true', {
                        path: '/',
                        expires: <?= $banner->show_after ?>
                    });
                });

                $("#click_modal").on("click", function () {
                    $.cookie(cookie_name, 'true', {
                        path: '/',
                        expires: <?= $banner->show_after ?>
                    });
                });
            });
        </script>
    @endpush
@endif