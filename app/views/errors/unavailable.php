<?php require_once "../app/views/layouts/header.php"; ?>
<section class="video">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-sm-8 col-12">
                <div class="video__unavailable">
                    <div class="video__unavailable-content">
                        <svg class="video__unavailable-content--icon">
                            <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-notice"></use>
                        </svg>
                        <p class="video__unavailable-content--text">Video unavailable</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once "../app/views/layouts/footer.php"; ?>