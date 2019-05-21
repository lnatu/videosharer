$(document).ready(function () {
    $('#likeVideo').on('click', function (e) {
        e.preventDefault();
        if($('#loggedIn').val()) {
            $('.video__likes--link').not(this).removeClass('active');
            $(this).toggleClass('active');
            likeVideo();
        } else {
            $('.video__likes--link').not(this).next().removeClass('active');
            $(this).next('.video__likes-popup').toggleClass('active');
        }
    });
    $('#dislikeVideo').on('click', function (e) {
        e.preventDefault();
        if($('#loggedIn').val()) {
            $('.video__likes--link').not(this).removeClass('active');
            $(this).toggleClass('active');
            dislikeVideo();
        } else {
            $('.video__likes--link').not(this).next().removeClass('active');
            $(this).next('.video__likes-popup').toggleClass('active');
        }
    });
});

function likeVideo() {
    var videoId = $('#videoId').val();
    $.ajax({
        url: `${rootUrl}videos/like`,
        type: "POST", 
        data: { videoId: videoId },
        success: function (data) {
            var res = JSON.parse(data);
            updateLikes($('#likesText'), res.likes);
            updateLikes($('#dislikesText'), res.dislikes);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
        }  
    });
}

function dislikeVideo() {
    var videoId = $('#videoId').val();
    $.ajax({
        url: `${rootUrl}videos/dislike`,
        type: "POST", 
        data: { videoId: videoId },
        success: function (data) {
            var res = JSON.parse(data);
            updateLikes($('#likesText'), res.likes);
            updateLikes($('#dislikesText'), res.dislikes);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
        }  
    });
}

function updateLikes(el, num) {
    var likesText = el.text() || 0;
    $likes = parseInt(likesText) + parseInt(num);
    el.text($likes > 0 ? $likes : '');
}
