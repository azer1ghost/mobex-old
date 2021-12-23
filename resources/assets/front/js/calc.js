arr = [];
arr.join(' ');
$('.product_list li a').click(function (e) {
    var clicked = $(this).parent('li').find('.pro_name').text();
    var clicked_comma = clicked + ',';
    if (jQuery.inArray(clicked_comma, arr) == -1) {
        arr.push(clicked_comma);
    }
    e.preventDefault();
    $('#horizontal-tabs__item-1').hide();
    $('.selected_cont_parent').show();
    $(this).addClass('selected_product');


    document.getElementById("showbox_text").innerHTML = arr.join(' ');
});

$('.delete_all').click(function () {
    arr = [];
    document.getElementById("showbox_text").innerHTML = arr.join(' ');

    $('#horizontal-tabs__item-1').show();
    $('.selected_cont_parent').hide();
    $('.product_list li a').removeClass('selected_product');
    $('#libs_cont span').text('0');
    $('.product_list li a').attr('data-count', '0');
    $('.select_count').text('');

});

$('.close_selected').click(function () {
    var deleted = $(this).parent('li').find('.pro_name').text();
    var a = arr.indexOf(deleted + ',');
    var deleted_item_data_count = $(this).parent('li').find('a').attr('data-count');
    if (deleted_item_data_count < 2) {
        delete arr[a];

    }

    var filtered_arr = arr.filter(item => item);
    if (filtered_arr.length == 0) {
        $('#horizontal-tabs__item-1').show();
        $('.selected_cont_parent').hide();
    }


    document.getElementById("showbox_text").innerHTML = arr.join(' ');
});


$('.product_list  li a').click(function (e) {
    var ncount = ($(this).attr('data-count') * 1);
    ncount += 1;
    count_data = $(this).attr('data-count', ncount);
    $(this).parent('li').find('.select_count').text(ncount + 'X');

    var libs_cont = ($('#libs_cont span').text() * 1);
    var data_weight = $(this).parent('li').find('.pro_weight').attr('data-weight');
    var last_total = (libs_cont * 1) + (data_weight * 1);
    last_total = last_total.toFixed(2);
    $('#libs_cont span').text(last_total);
    $('#weight').val(last_total);
    calcPrice();

});

$('.close_selected').click(function () {
    var d_click = $(this).parent('li').find('a').attr('data-count');
    var total_after_delete = ($('#libs_cont span').text() * 1);
    d_click -= 1;
    if (d_click > -1) {
        d_count_data = $(this).parent('li').find('a').attr('data-count', d_click);
    }

    if (d_click == 0) {
        $(this).parent('li').find('a').removeClass('selected_product');
    }
    $(this).parent('li').find('.select_count').text(d_click + 'X');
    var data_weight = $(this).parent('li').find('.pro_weight').attr('data-weight');
    if (d_click > -1) {
        var last_total = (total_after_delete * 1) - (data_weight * 1);
        last_total = last_total.toFixed(2);
        $('#libs_cont span').text(last_total);
    }
    $('#weight').val(last_total);
    calcPrice();
});