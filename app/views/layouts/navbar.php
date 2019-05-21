<nav class="nav">
    <div class="nav__menu">
        <div class="nav__menu-toggle">
            <a href="#" class="nav__menu-toggle--link">
                <span class="nav__menu-toggle--icon"></span>
                <span class="nav__menu-toggle--icon"></span>
                <span class="nav__menu-toggle--icon"></span>
            </a>
        </div>
        <div class="nav__menu-logo">
            <a href="<?php echo URL_ROOT; ?>"><img src="<?php echo URL_ROOT; ?>assets/img/logo/logo.png" alt="Logo" class="nav__menu-logo--img"></a>
        </div>
    </div>
    <div class="nav__search">
        <div class="nav__search-box">
            <form action="">
                <div class="form-group nav__search-box--group">
                    <input type="text" class="form-control nav__search-box--input" name="search">
                    <button type="submit" class="nav__search-box--button">
                         <svg class="nav__search-box--icon">
                            <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-magnifier"></use>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="nav__user">
        <div class="nav__user-box">
            <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="<?php echo URL_ROOT; ?>uploads" class="nav__user-box--link">
                <svg class="nav__user-box--icon">
                    <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-camera"></use>
                </svg>
            </a>    
            <a href="<?php echo URL_ROOT; ?>users/register" class="nav__user-box--link">
                <svg class="nav__user-box--icon">
                    <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-user-circle"></use>
                </svg>
            </a>
            <?php else: ?>
            <a href="<?php echo URL_ROOT; ?>uploads" class="nav__user-box--link">
            <?php echo $_SESSION['user_name']; ?>
            </a> 
            <a href="<?php echo URL_ROOT; ?>uploads" class="nav__user-box--link">
                <svg class="nav__user-box--icon">
                    <use xlink:href="<?php echo URL_ROOT; ?>assets/img/icon/sprite.svg#icon-camera"></use>
                </svg>
            </a>    
            <a href="<?php echo URL_ROOT; ?>users/register" class="nav__user-box--link">
                <img src="<?php echo URL_ROOT.$_SESSION['user_image']; ?>" alt="<?php echo $_SESSION['user_name']; ?>"  class="nav__user-box--img">
            </a>
            <?php endif; ?>
        </div>
    </div>
</nav>