$(document).ready(function () {
    $('#sendComment').on('click', function (e) {
        e.preventDefault();
        if($('#comment').val()) {
            comment();
            $('#comment').val() = "";
        } else {
            return;
        }
    });
});

function comment() {
    var userId = $('#userId').val();
    var videoId = $('#videoId').val();
    var responseTo = 0;
    var content = $('#comment').val();
    var markup = `<div class="comments__box">
                        <div class="comments__box-user">
                            <a href="#" class="comments__box-user--link">
                                <img src="${rootUrl}%profilePicture%" alt="%username%" class="comments__box-user--img">
                            </a>
                        </div>
                        <div class="comments__box-content">
                            <div class="comments__box-content-header">
                                <a href="#" class="comments__box-content-header--name">%username% <span class="comments__box-content-header--time">Just now</span></a>
                                <p class="comments__box-content--comment">%comment%</p>
                            </div>
                            <div class="comments__box-content-actions">
                                <a href="#" class="comments__box-content-actions--link">
                                    <svg class="comments__box-content-actions--icon">
                                        <use xlink:href="${rootUrl}assets/img/icon/sprite.svg#icon-thumbs-up"></use>
                                    </svg>
                                    <span class="comments__box-content-actions--text"></span>
                                </a>
                                <a href="#" class="comments__box-content-actions--link">
                                    <svg class="comments__box-content-actions--icon">
                                        <use xlink:href="${rootUrl}assets/img/icon/sprite.svg#icon-thumbs-down"></use>
                                    </svg>
                                </a>
                                <a href="#" class="comments__box-content-actions--link">
                                    REPLY
                                </a>
                            </div>
                        </div>
                    </div>`;
    $.ajax({
        url: `${rootUrl}comments/comment`,
        type: "POST", 
        data: { userId, videoId, responseTo, content },
        success: function (data) {
            var res = JSON.parse(data);
            console.log(res);
            $('#totalComments').text(res.totalComments);
            var newMarkup = markup.replace('%profilePicture%', res.user.profile_picture);
            newMarkup = newMarkup.replace('%username%', res.user.first_name + ' ' + res.user.last_name);
            newMarkup = newMarkup.replace('%username%', res.user.first_name + ' ' + res.user.last_name);
            newMarkup = newMarkup.replace('%comment%', res.comment);
            console.log(newMarkup);
            document.querySelector('.comments').insertAdjacentHTML('afterbegin', newMarkup);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
        }  
    });
}