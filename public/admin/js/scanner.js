$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
});

// steal focus during close - only capture once and stop propogation
$('select.select2').on('select2:closing', function (e) {
    $(e.target).data("select2").$selection.one('focus focusin', function (e) {
        e.stopPropagation();
    });
});

function alertWithSound(data) {
    var sound = 'error';
    if (data.sound) {
        sound  = data.sound;
    }
    ion.sound.play(sound);

    swal({
        "timer": 3000,
        "title": data.error,
        "showConfirmButton": false,
        "type": "error"
    });
}

$(document).ready(function () {
    _packageCreate = $("#create_package").data('url');

    $("input[name='shipping_amount'],input[name='weight'], input[name='admin_paid'], input[name='amount']").on("keyup", function () {
        var val = $(this).val();
        val = val.replace(',', '.');
        $(this).val(val);
    });

    $("input[name='shipping_amount']").on("keyup", function () {
        if (parseFloat($(this).val()) >= 900) {
            $("#alert_price").show();
        } else {
            $("#alert_price").hide();
        }
    });

    var userPackages = $("#user_packages");
    $("select[name='user_id']").on('change', function () {
        var id = $(this).children("option:selected").val();
        var userPackagesRoute = userPackages.data('route') + "/" + id;
        setTimeout(
            function () {
                $("input[name='website_name']").focus();
            }, 100);

        $.getJSON(userPackagesRoute, function (data) {
            if (data.html != "" && data.html) {
                $("#body_packages").html(data.html);
                userPackages.show();
            } else {
                $("#body_packages").html();
                userPackages.hide();
            }

        });


    });

    $(document).on('change', '.type_item select', function () {
        var thisSelect = $(this);
        setTimeout(
            function () {
                thisSelect.parents(".type_item").find("input").focus();
            }, 100);
    });

    $(document).on('click', '.rescan-package', function () {
        var tc = $(this).data('tc');
        $("#new_package").modal('hide');
        loadBarcodeData(tc, null);
    });

    $(".change_volume").on("keyup", function () {
        var delivery_index = parseInt($("#delivery_index").data('value'));
        var width = parseFloat($("input[name='width']").val());
        var height = parseFloat($("input[name='height']").val());
        var length = parseFloat($("input[name='length']").val());

        var weight = parseFloat($("input[name='weight']").val());
        var volumeWeight = width * height * length / delivery_index;
        volumeWeight = isNaN(volumeWeight) ? 0 : parseFloat(volumeWeight).toFixed(2);
        weight = isNaN(weight) ? 0 : parseFloat(weight);

        $("input[name='volume_weight']").val(volumeWeight);

        $(".active_weight").removeClass('active_weight');
        if (Math.round(weight * 100) < Math.round(volumeWeight * 100)) {
            $(".volume_id").addClass("active_weight");
        } else {
            $(".weight_id").addClass("active_weight");
        }

        if (Math.round(volumeWeight * 100) >= 900 || Math.round(weight * 100) >= 900) {
            $("#alert_weight").show();
        } else {
            $("#alert_weight").hide();
        }
    });

    function clonePackageType() {
        var clone = $("#main_type_item").clone();
        clone.removeAttr("id");
        clone.addClass("extra_type");
        clone.find(".select2-container").remove();
        clone.find("select").select2();

        //clone.find("select[name='type_id']").removeAttr("data-validation");
        //clone.find("select[name='type_id']").attr("name", "type[]");

        //clone.find("input[name='number_items']").removeAttr("data-validation");
        //clone.find("input[name='number_items']").attr("name", "items[]");
        clone.find("input").val(1);
        $("#type_section").append(clone);
    }

    $("#add_type").on("click", function () {
        clonePackageType();
    });

    $(document).on('click', '.btn_minus', function () {
        $(this).parents(".type_item").remove();
    });

    _addPackage = $("#form_add_package");
    _addPackage.on("submit", function (e) {
        e.preventDefault();
        $("#loading").show();
        var seri = _addPackage.serialize();
        var _route = _addPackage.attr('action');
        $.post(_route, seri, function (data) {
            clearAddPackage();

            let web_site = "";
            if (data.web_site) {
                web_site = data.web_site;
            }
            _addPackage.find("input[name=website_name]").val(web_site);

            $(".hidden_for_user").show();
            $("#new_package").modal("hide");

            if (data.cwb) {
                loadBarcodeData(data.cwb, null);
            } else {
                alertWithSound(data);
            }

            $("#loading").hide();
        });
    });


    $("select[name='limit']").on('change', function () {
        $(this).parents('form').submit();
    });


    $(document).on('click', '.delete-package', function () {
        _packageItem = $(this);
        _id = $("#scanned").data('id');
        _packageId = $(this).data('item');
        var _url = $("#delete_url").data('delete-url') + "/" + _id + "/" + _packageId;

        $.post(_url, function (data) {
            if (data.error) {
                alertWithSound(data);
            } else {

                _packageItem.parents('tr').remove();
                if ($(".scanned_package").length == 0) {
                    $("#empty_package").show();
                }

                var el = parseInt($('#waiting_packages').text());
                $('.waiting_packages').text(el + 1);
            }

        });

    });

    $("#manual_add_package").on("submit", function (e) {
        e.preventDefault();
        var barcode = $("#manual_add").val();

        if (barcode != "") {
            loadBarcodeData(barcode, null);
        }
    });

    $(document).on("keypress", function (e) {
        if ($("#modal").hasClass('in') && (e.keycode == 13 || e.which == 13)) {
            $("#modal").modal("hide");
        }

        if ($("#new_package").hasClass('in')) {
            var keys = {
                '33': 1,
                '64': 2,
                '35': 3,
                '36': 4,
                '37': 5,
                '94': 6,
                '38': 7,
                '42': 8,
                '40': 9,
            };
            if (e.shiftKey && keys[e.which]) {
                e.preventDefault();
                var packId = keys[e.which];
                $("#" + packId + "_add").click();
            }

            if (e.shiftKey && (e.which == 43)) {
                e.preventDefault();
                clonePackageType();
            }
            if (e.shiftKey && (e.which == 95)) {
                e.preventDefault();
                if ($(".type_item").length > 1) {
                    $(".type_item:last").remove();
                }
            }
        }

        if (e.shiftKey && (e.which == 13)) {

            e.preventDefault();
            if ($("#new_package").length > 0) {
                $("#new_package").modal("show");
                $("#new_package input[name='tracking_code']").focus();
            } else {
                if (window.location != _packageCreate) {
                    $("#loading").show();
                    window.location = _packageCreate;
                }
            }

        }
    });

});
$(document).scannerDetection({
    timeBeforeScanTest: 200,
    endChar: [13],
    avgTimeByChar: 40,
    onComplete: function (barcode, qty) {
        if (barcode) {
            loadBarcodeData(barcode, qty)
        }
    }
});


function clearAddPackage() {

    $("#new_package input[type=text][name!='website_name'], textarea").val("");
    $("#body_packages").html("");
    $("#user_packages").hide();
    $("#alert_weight").hide();
    $("#alert_price").hide();
    $("#body_packages").html();
    $("#user_packages").hide();
    $(".extra_type").remove();

    $('input[name="has_liquid"]').prop('checked',false);
    $.uniform.update('input[name="has_liquid"]');

    $('input[name="has_battery"]').prop('checked',false);
    $.uniform.update('input[name="has_battery"]');

    $('input[name="print_invoice"]').prop('checked', true);
    $.uniform.update('input[name="print_invoice"]');

    $(".select2-container").remove();
    $("select").removeClass("select-search valid select2-hidden-accessible");
    $('option:selected', $("select[touch!='no']")).removeAttr('selected');

    $("#new_package input[name='items[]']").eq(0).val(1);
    $("#new_package select[name='types[]']").eq(0).val(108);

    $("select[name='user_id']").removeAttr('disabled');
    $("select[name='user_id']").attr('data-validation', 'required');

    $("select:not(.select2-ajax)[touch!='no']").select2();
    $(".select2-ajax").each(function () {
        var s2 = $(this);
        s2.select2({
            minimumInputLength: 3,
            ajax: {
                url: s2.data("url"),
                dataType: 'json',
            },
        });
    });
}

function loadBarcodeData(barcode, qty) {

    $('#modal').modal('hide');

    var _url = $("#scan_url").data('scan-url') + "?code=" + barcode;
    var autoPrint = $("#auto_print").data('enabled');
    fakeInvoice = $("#fake_invoice").data('enabled');
    var showInvoice = $("#show_invoice").data('enabled');
    var showLabel = $("#show_label").data('enabled');
    var scannerTab = $("#scanned");
    if (scannerTab.length > 0) {
        _id = scannerTab.data('id');
        _url = _url + "&scan=" + _id;
    }


    $.getJSON(_url, function (data) {
        //console.log(data);
        if (data.error) {
            alertWithSound(data);

            // If not parcels page redirect to package create

        } else if (data.redirect) {
            window.location = data.redirect;
        } else if (data.add_package) {
            if ($("#new_package").length > 0) {
                clearAddPackage();
                $("#new_package input[name='tracking_code']").val(barcode);
                var selectUser = $("select[name='user_id']");

                if (data.user && data.user == 'yes') {
                    $("#user_id").hide();
                    $(".hidden_for_user").hide();
                    selectUser.attr("disabled", "disabled");
                    selectUser.attr("data-validation", "null");
                    $("#user_id .select2-container").remove();
                } else {
                    $("#user_id").show();
                    $(".hidden_for_user").show();
                }
                $("#new_package").modal("show");
                $("#new_package input[name='tracking_code']").focus();
            }
        } else if (data.success) {
            swal({
                "timer": 3000,
                "title": data.success,
                "showConfirmButton": false,
                "type": "success"
            });
        } else {
            if ($("#scanned").length > 0 && data.html) {
                if ($("#package_" + data.id).length == 0) {
                    $("#empty_package").hide();
                    scannerTab.append(data.html);
                    if (data.sound == 'yes') {
                        ion.sound.play("added");
                    }
                    var n = $(document).height();
                    $('html, body').animate({scrollTop: n}, 50);

                    $("#manual_add").val("");
                    var el = data.weight;
                    if (el) {
                        $('.waiting_packages').text(el);
                    }

                    clearAddPackage();
                }

            }

            if (data.label) {
                if (autoPrint == 'yes') {
                    var printerName = "label_printer";
                    if (data.waybill == "yes") {
                        printerName = "invoice_printer";
                    }
                    var printerForLabel = Cookies.get(printerName); // will come from setting

                    var cpj = new JSPM.ClientPrintJob();
                    cpj.clientPrinter = new JSPM.InstalledPrinter(printerForLabel);
                    var copies = 1;
                    /* if (fakeInvoice == 'yes') {
                         copies = 2;
                     }*/
                    var labelPDF = new JSPM.PrintFilePDF(data.label, JSPM.FileSourceType.URL, 'MyLabelFile.pdf', copies);
                    cpj.files.push(labelPDF);

                    if (fakeInvoice == 'yes') {
                        var labelPDF2 = new JSPM.PrintFilePDF(data.label, JSPM.FileSourceType.URL, 'MyLabelFile2.pdf', 1);
                        cpj.files.push(labelPDF2);
                    }

                    //console.log("Label");
                    cpj.sendToClient();
                } else {
                    if (showLabel == 'yes') {
                        window.open(data.label);
                    }

                }

            }
            if (data.invoice) {
                if (autoPrint == 'yes') {
                    var ext = (data.invoice.split('.').pop()).toLowerCase();
                    var printerForLabel = Cookies.get('invoice_printer'); // will come from setting
                    var cpj2 = new JSPM.ClientPrintJob();
                    cpj2.clientPrinter = new JSPM.InstalledPrinter(printerForLabel);

                    if (ext == 'pdf') {
                        var invoiceFile = new JSPM.PrintFilePDF(data.invoice, JSPM.FileSourceType.URL, 'MyInvoice.pdf', 1);

                    } else {
                        var invoiceFile = new JSPM.PrintFile(data.invoice, JSPM.FileSourceType.URL, 'MyInvoice.' + ext, 1);

                    }
                    cpj2.files.push(invoiceFile);
                    cpj2.sendToClient();
                } else {
                    if (showInvoice == 'yes') {
                        window.open(data.invoice);
                    }
                }
            }


            if (data.package) {
                $("#modal .modal-dialog").html(data.package);
                $('#modal').modal('show');
            }

        }

    });
}