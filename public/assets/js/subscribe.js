$(document).ready(function () {
    $('.video__details-subscribe--btn').on('click', function (e) {
        e.preventDefault();

        if ($(this).hasClass('edit')) {

            return false;
            
        } else {

            if($('#loggedIn').val()) {
                subScribe($(this));
            } else {
                $('.video__likes--link').not(this).next().removeClass('active');
                $(this).next('.video__likes-popup').toggleClass('active');
            }

        }
    });
});

function subScribe(button) {
    var user = $('#userId').val();
    var channel = $('#channelId').val();
    $.ajax({
        url: `${rootUrl}subscribes/subscribe`,
        type: "POST", 
        data: { user: user, channel: channel },
        success: function (data) {
            var result = JSON.parse(data);
            var defaultClass = 'video__details-subscribe--btn';
            button.attr('class', defaultClass + ' ' + result.class);

            var buttonText = $(button).hasClass('subscribe') ? "subscribe" : "subscribed";
            button.text(buttonText + " " + result.subsCount);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
        }  
    });
}