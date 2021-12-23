function checkEmail(str) {

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(str.val())) {

        str.val('');
        str.focus();
        return false;
    }
};

function alert_fun(message, klass = 'error', redirect = false) {
    swal({
        title: message,
        text: '',
        icon: klass,
        button: 'BaÄŸla',

    }).then(function () {

        if (redirect) {
            window.location.href = redirect;
        }

    });
};

function calcPrice() {
    var formData = $("#calc_form").serialize();
    var route = $("#price_calculator").data('route');
    $.get(route, formData, function (data) {
        $(".calc_price").text(data);
    });
}

$(document).ready(function () {
    $('#calc_form select').on('change', calcPrice);
    $('#calc_form input').on('keyup paste', calcPrice);


    $('input[type=email], .email').on('change', function () {
        var bu = $(this);
        checkEmail(bu);
    });


    $('.form').on('submit', function () {
        var curr_form = $(this),
            error = false,
            first_input = null;

        curr_form.find('.required').each(function () {
            var bu = $(this),
                val = bu.val();

            if ($.trim(val) == '' || val == 0) {
                error = true;
                bu.addClass('must_fill').removeClass('req_input_filled');

                if (!first_input) {
                    first_input = bu;
                }
            } else {
                bu.removeClass('must_fill').addClass('req_input_filled');
            }

            bu.change(function () {
                var new_val = bu.val();

                if ($.trim(new_val) == '' || new_val == 0) {
                    bu.addClass('must_fill').removeClass('req_input_filled');
                } else {
                    bu.removeClass('must_fill').addClass('req_input_filled');
                }
            });
        });


        if (!error) {

            if (!error) {

                if (!error) {

                    let person = $('[name="person"]').val();
                    let firstname = $('[name="firstname"]').val();
                    let lastname = $('[name="lastname"]').val();
                    let number = $('[name="number"]').val();
                    let email = $('[name="email"]').val();
                    let content = $('[name="content"]').val();
                    let recaptcha = $('[name="recaptcha"]').val();
                    let section = $('[name="section"]').val();

                    let url = section ? '/services/send' : '/contact/send';

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            person: person,
                            firstname: firstname,
                            lastname: lastname,
                            person: person,
                            number: number,
                            email: email,
                            content: content,
                            section: section,
                            recaptcha: recaptcha
                        },
                        dataType: 'json',
                        success: function (e) {
                            if (e.success != true) {

                                Swal.fire({
                                    icon: 'error',
                                    text: e.errors,
                                });
                                grecaptcha.reset();
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Sizin istÉ™k qeydÉ™ alÄ±ndÄ±.',
                                });

                                setTimeout(function () {
                                    window.location.reload();
                                }, 3000);
                            }
                        }
                    });


                    return false;
                } else {

                    return false;

                }
            }

        } else {


            Swal.fire({
                icon: 'error',
                text: 'Vacib xanalari doldurun',
            });


            return false;
        }

        return false;
    });

});


$(document).ready(function () {
    $('.choose_package_drop_open').click(function () {
        $(this).parent('.choose_package_dropdown ').find('.choose_package_drop').toggleClass('opened');
        $(this).toggleClass('opened_button');
    });

});


const copyToClipboard = function (text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.select();
    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
    } catch (err) {
        console.log('Oops, unable to copy');
    }
    document.body.removeChild(textArea);
}


// Copy address text
$(document).on('click', '.copy_text', function () {
    var t = $(this);
    t.addClass('copied')
    copyToClipboard(t.parent().children('p').text());
    setTimeout(function () {
        t.removeClass('copied')
    }, 500);
});

// Copy sub-account url
$(document).on('click', '.link_copy', function () {
    var t = $(this);
    copyToClipboard(t.parent().children('p').text());
    alert('link copied');
});

$(document).ready(function () {

    $(document).bind('input', '.order_price, .order_amount, .order_kargo_fee', function () {
        calculatePrice();
    });

    function calculatePrice() {
        var sum = 0;

        $('.order_price').each(function () {
            $this_price = parseFloat($(this).parents('.order_box').find('.order_price').val().replace(',', '.'));
            $this_amount = parseInt($(this).parents('.order_box').find('.order_amount').val());
            $this_kargo = parseFloat($(this).parents('.order_box').find('.order_kargo_fee').val().replace(',', '.'));
            curSum = Number($this_price) * Number($this_amount);
            if ($this_kargo) {
                curSum += $this_kargo;
            }
            if (!curSum) {
                curSum = 0;
            }
            sum += curSum;
        });

        if (!sum) {
            sum = 0;
        }
        sum = sum.toFixed(2);
        $("#calc_order_price").text(sum + ' TL');
        $("#cargo_fee_value").text((sum * 0.05).toFixed(2) + ' TL');
        $("#overall_fee").text((sum * 1.05).toFixed(2) + ' TL');
    }

    $(document).on('input', '.order_price, .order_kargo_fee', function () {
        $(this).val($(this).val().replace(/,/g, '.'));
    });

    $(document).ready(function () {
        $(document).on('click', '.add_order', function () {
            count = 1;
            var cloned = $(".added_order_row:first-child").clone();
            html = '<div class="row order_box added_order_row"> ' + cloned.html() + ' </div>';

            $('#container-url').append(html);
            let hesterx = document.getElementsByClassName('count-item__count');
            for (var i = 0; i < hesterx.length; i++) {
                hesterx[i].innerHTML = (i < 9 ? '0' : '') + (i + 1);
                $(".order_box:nth-child(" + (i + 1) + ") ").attr("data-id", i);
            }


            $(".order_box input").each(function (i) {
                var key = $(this).data('key');
                var id = $(this).parents(".order_box").data("id");
                $(this).attr('name', "url[" + id + "][" + key +"]");
            });
        });

        $(document).on('click', '.delete_order', function () {
            $(this).parents('.added_order_row').remove();
            let hesterx = document.getElementsByClassName('count-item__count');
            for (var i = 0; i < hesterx.length; i++) {
                hesterx[i].innerHTML = (i < 9 ? '0' : '') + (i + 1);
                $(".order_box:nth-child(" + (i + 1) + ") ").attr("data-id", i);
            }
            $(".order_box input").each(function (i) {
                var key = $(this).data('key');
                $(this).attr('name', "url[" + i + "][" + key +"]");
            });
        });
    });
});

$('.cart-totals .button--account').click(function () {
    if ($('.mss .form__input-checkbox').is(':checked')) {
        $('.form__input-checkbox:checked+.form__checkbox-mask').css('border-color', '#00997d');
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Vacib xananı doldurun',
        });
        $('.form__checkbox-mask').css('border', '2px solid red');
        return false;
    }
});
$('.form__input-checkbox').on('change', function () {
    if ($('.mss .form__input-checkbox').is(':checked')) {
        $('.form__input-checkbox:checked+.form__checkbox-mask').css('border-color', '#00997d');
    } else {
        $('.form__checkbox-mask').css('border', '2px solid #e2e2e2');
    }
});