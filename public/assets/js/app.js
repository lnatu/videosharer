$(document).ready(function () {

    $('#uploadForm').submit(function () {
        $('#uploadModal').modal('show');
        disableKey();
    });

    $('.register__box-body--input').on('focus', function () {
        $(this).prev().addClass('active');
        $(this).parent().addClass('active');
    }).on('blur', function () {
        if (!$(this).val()) {
            $(this).prev().removeClass('active');
            $(this).parent().removeClass('active');
        }
    });

    $('.register__box-body--input').on('input', function () {
        if (!$(this).val()) {
            $(this).prev().removeClass('active');
        } else {
            $(this).prev().addClass('active');
        }
    });

    $('#comment').on('focus', function() {
        $(this).parent().addClass('active');
        $(this).parent().next().removeClass('hide');
    }).on('blur', function() {
        if (!$(this).val()) {
            $(this).parent().removeClass('active');
         $(this).parent().next().addClass('hide');
        }
    }).on('input', function() {
        if (!$(this).val()) {
            $(this).parent().next().find('.comment').removeClass('active');
        } else {
            $(this).parent().next().find('.comment').addClass('active');
        }
    });

});

$(window).on('load', function () {
    var inputs = $('.register__box-body--input');
    inputs.each(function () {
        if ($(this).val()) {
            $(this).prev().addClass('active');
            $(this).parent().addClass('active');
        }
    });
});

function disableKey() {
    $(window).keydown(function (event) {
        if (event.which == 27) {
            event.preventDefault();
            return false;
        }
    });
}
