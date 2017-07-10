jQuery(document).ready(function($) {
    // start main program module
    ttp_module.load();
});

var ttp_module = (function ($, w) {
    "use strict";

    var load = function () {
        init_vars();
        set_handlers();
    };

    var set_handlers = function () {

        $('#order-submit').click(function (e) {
            e.preventDefault();
            var result = $('#form-order').serialize();
            var data = {
                action: 'insert_order',
                security: $('#security').val(),
                form: result
            };
            doAjax(data, orderSuccess);
        });

        $('#tt_add_order').click(function (e) {
            var value = $(this).attr('data-name');
            $('.modal .product-name').val(value);
        });
    }

    var orderSuccess = function ( result ) {
        result = JSON.parse( result );
        if ( result.success == true ) {
            doSuccess(result.message);
        } else {
            doError(result.message);
        }
    };

    var doSuccess = function (message) {
        $('.modal').modal('hide');
        $('#msgModal .modal-body').text( message );
        $('#msgModal').modal('show');
    }

    var doError = function (message) {
        $('.modal').modal('hide');
        $('#msgModal .modal-body').text( message );
        $('#msgModal').modal('show');
    }

    var doAjax = function (data, success) {
        $.ajax({
            type: 'post',
            url: w.tt_ajax.url,
            data: data,
            beforeSend: function () {
                //loader.show();
                formDisable();
            },
            complete: function () {
                formEnable();
                //loader.hide();
            },
            success: success,
            error: function(result) {
                doError('Неизвестная ошибка');
            },
        });
    };

    var init_vars = function () {}

    var formDisable = function () {
        $('#form-order').find('input, button, select').attr('disabled','disabled');
    };

    var formEnable = function () {
        $('#form-order').find('input, button, select').attr('disabled', false);
    };

    return {
        load : load
    }

})(jQuery, window);