<?php require_once "../app/views/layouts/header.php"; ?>
<section class="video">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-8">
                <div class="video__box">
                    <video class="video__box-file" controls>
                        <source src="<?php echo URL_ROOT.$data['video']->file_path; ?>" type="video/mp4">
                        Your browser does not support the video
                    </video>
                </div>

                <div class="video__heading">
                    <div class="video__heading-title">
                        <h1 class="video__heading-title--name"><?php echo $data['video']->title; ?></h1>
                        <p class="video__heading-title--views"><?php echo $data['video']->views; ?> views</p>
                    </div>
                    <div class="video__likes">
                        <div class="video__likes-box">
                            <a href="#" class="video__likes--link <?php echo $data['isLiked'] ? 'active' : ''; ?>" id="likeVideo">
                                <svg class="video__likes--icon">
                                    <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-thumbs-up"></use>
                                </svg>
                                <span class="video__likes--text" id="likesText"><?php echo $data['total_likes'] > 0 ? $data['total_likes'] : ''; ?></span>
                            </a>
                            <div class="video__likes-popup">
                                <div class="video__likes-popup-header">
                                    <h2 class="video__likes-popup-header--title">Like this video ?</h2>
                                    <p class="video__likes-popup-header--text">Sign in to make your opinion count.</p>
                                </div>
                                <div class="video__likes-popup-footer">
                                    <a href="<?php echo URL_ROOT; ?>users/login" class="video__likes-popup-footer--link">sign in</a>
                                </div>
                            </div>
                        </div>
                        <div class="videos__likes-box">
                            <a href="#" class="video__likes--link <?php echo $data['isDisliked'] ? 'active' : ''; ?>" id="dislikeVideo">
                                <svg class="video__likes--icon">
                                    <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-thumbs-down"></use>
                                </svg>
                                <span class="video__likes--text" id="dislikesText"><?php echo $data['total_dislikes'] > 0 ? $data['total_dislikes'] : ''; ?></span>
                            </a>
                            <div class="video__likes-popup">
                                <div class="video__likes-popup-header">
                                    <h2 class="video__likes-popup-header--title">Don't like this video ?</h2>
                                    <p class="video__likes-popup-header--text">Sign in to make your opinion count.</p>
                                </div>
                                <div class="video__likes-popup-footer">
                                    <a href="<?php echo URL_ROOT; ?>users/login" class="video__likes-popup-footer--link">sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="video__details">
                    <div class="video__details-channel">
                        <a href="#" class="video__details-channel--link">
                            <img src="<?php echo URL_ROOT.$data['video']->profile_picture; ?>" alt="user" class="video__details-channel--img">
                        </a>
                    </div>
                    <div class="video__details-description">
                        <div class="video__description-header">
                            <h3 class="video__description-header--channel"><?php echo $data['channel_name']; ?></h3>
                            <p class="video__description-header--date">Published on <?php echo $data['publish_date']; ?></p>
                        </div>
                        <div class="video__description-body">
                            <p class="video__description-body--text"><?php echo $data['video']->description; ?>"</p>
                        </div>
                    </div>
                    <div class="video__details-subscribe">
                        <a href="#" class="video__details-subscribe--btn <?php echo $data['subscribeClass']; ?>"><?php echo $data['subscribeClass']; ?> <?php echo $data['totalSubs']; ?></a>
                        <div class="video__likes-popup video__details-subscribe-popup">
                            <div class="video__likes-popup-header">
                                <h2 class="video__likes-popup-header--title">Want to subscribe to this channel ?</h2>
                                <p class="video__likes-popup-header--text">Sign in to subscribe to this channel.</p>
                            </div>
                            <div class="video__likes-popup-footer">
                                <a href="<?php echo URL_ROOT; ?>users/login" class="video__likes-popup-footer--link">sign in</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="video__addComment">
                    <div class="video__addComment-count">
                        <p class="video__addComment-count--text"><span id="totalComments"><?php echo $data['totalComments']; ?></span> Comments</p>
                    </div>
                    <div class="video__addComment-box">
                        <div class="video__addComment-user">
                            <a href="#" class="video__addComment-user--link">
                                <img src="<?php echo URL_ROOT; ?>assets/img/icon/user.png" alt="" class="video__addComment-user--img">
                            </a>
                        </div>
                        <div class="video__addComment-form">
                            <div class="form-group video__addComment-form-group">
                                <textarea name="comment" id="comment" class="video__addComment-form--input form-control" placeholder="Add a public comment..."></textarea>
                            </div>
                            <div class="video__addComment-control hide">
                                <a href="#" class="video__addComment-control--btn cancel">cancel</a>
                                <a href="#" class="video__addComment-control--btn comment disabled" id="sendComment">comment</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="comments">
                    <!-- <div class="comments__box">
                        <div class="comments__box-user">
                            <a href="#" class="comments__box-user--link">
                                <img src="<?php echo URL_ROOT; ?>assets/img/icon/user.png" alt="user" class="comments__box-user--img">
                            </a>
                        </div>
                        <div class="comments__box-content">
                            <div class="comments__box-content-header">
                                <a href="#" class="comments__box-content-header--name">Peter Quill <span class="comments__box-content-header--time">1 year ago</span></a>
                                <p class="comments__box-content--comment">It went from “Want You Back” to “None of My Bussiness”</p>
                            </div>
                            <div class="comments__box-content-actions">
                                <a href="#" class="comments__box-content-actions--link">
                                    <svg class="comments__box-content-actions--icon">
                                        <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-thumbs-up"></use>
                                    </svg>
                                    <span class="comments__box-content-actions--text">1</span>
                                </a>
                                <a href="#" class="comments__box-content-actions--link">
                                    <svg class="comments__box-content-actions--icon">
                                        <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-thumbs-down"></use>
                                    </svg>
                                </a>
                                <a href="#" class="comments__box-content-actions--link">
                                    REPLY
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <?php foreach($data['allComments'] as $comment) : ?>
                    <div class="comments__box">
                        <div class="comments__box-user">
                            <a href="#" class="comments__box-user--link">
                                <img src="<?php echo URL_ROOT.$comment -> profile_picture; ?>" alt="<?php echo $comment -> first_name. ' '.$comment -> last_name; ?>" class="comments__box-user--img">
                            </a>
                        </div>
                        <div class="comments__box-content">
                            <div class="comments__box-content-header">
                                <a href="#" class="comments__box-content-header--name"><?php echo $comment -> first_name. ' '.$comment -> last_name; ?> <span class="comments__box-content-header--time"><?php echo time_elapsed_string($comment -> commentCreated); ?></span></a>
                                <p class="comments__box-content--comment"><?php echo $comment -> content; ?></p>
                            </div>
                            <div class="comments__box-content-actions">
                                <a href="#" class="comments__box-content-actions--link">
                                    <svg class="comments__box-content-actions--icon">
                                        <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-thumbs-up"></use>
                                    </svg>
                                    <span class="comments__box-content-actions--text">1</span>
                                </a>
                                <a href="#" class="comments__box-content-actions--link">
                                    <svg class="comments__box-content-actions--icon">
                                        <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-thumbs-down"></use>
                                    </svg>
                                </a>
                                <a href="#" class="comments__box-content-actions--link">
                                    REPLY
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" value="<?php echo isset($_SESSION['user_id']); ?>" id="loggedIn">
                <input type="hidden" value="<?php echo $data['video']->videoId; ?>" id="videoId">
                <input type="hidden" value="<?php echo $_SESSION['user_id']; ?>" id="userId">
                <input type="hidden" value="<?php echo $data['video']->uploadedBy; ?>" id="channelId">
            </div>
        </div>
    </div>
</section>

<?php require_once "../app/views/layouts/footer.php"; ?>