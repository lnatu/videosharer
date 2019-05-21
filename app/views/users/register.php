<?php require_once "../app/views/layouts/header.php"; ?>
<section class="register">
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="register__box">
                    <div class="register__box-header">
                        <a href="<?php echo URL_ROOT; ?>" class="register__box-header--link">
                            <img src="<?php echo URL_ROOT; ?>assets/img/logo/logo.png" alt="Youtube logo" class="register__box-header--img">
                        </a>
                        <h1 class="register__box-header--title display-4">Sign Up</h1>
                        <p class="register__box-header--text">to continue to watch Youtube videos</p>
                    </div>
                    <div class="register__box-body" id="signUpForm">
                        <form action="<?php echo URL_ROOT; ?>users/register" method="POST" class="user__form">
                            <div class="form-group register__box-body--group">
                                <label class="register__box-body--label" for="firstname">First name</label>
                                <input type="text" name="firstname" value="<?php echo $data['first_name']; ?>" 
                                    id="firstname" class="form-control register__box-body--input">
                                <span class="text-danger error-message"><?php echo $data['first_name_err']; ?></span>
                            </div>
                            <div class="form-group register__box-body--group">
                                <label class="register__box-body--label" for="lastname">Last name</label>
                                <input type="text" name="lastname" value="<?php echo $data['last_name']; ?>" id="lastname"
                                    class="form-control register__box-body--input">
                                    <span class="text-danger error-message"><?php echo $data['last_name_err']; ?></span>
                            </div>
                            <div class="form-group register__box-body--group">
                                <label class="register__box-body--label" for="username">User name</label>
                                <input type="text" name="username" value="<?php echo $data['username']; ?>" id="username"
                                    class="form-control register__box-body--input">
                                    <span class="text-danger error-message"><?php echo $data['username_err']; ?></span>
                            </div>
                            <div class="form-group register__box-body--group">
                                <label class="register__box-body--label" for="email">Email</label>
                                <input type="email" name="email" value="<?php echo $data['email']; ?>" id="email"
                                    class="form-control register__box-body--input">
                                    <span class="text-danger error-message"><?php echo $data['email_err']; ?></span>
                            </div>
                            <div class="form-group register__box-body--group">
                                <label class="register__box-body--label" for="password">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control register__box-body--input">
                                    <span class="text-danger error-message"><?php echo $data['password_err']; ?></span>
                            </div>
                            <div class="form-group register__box-body--group">
                                <label class="register__box-body--label" for="confirmpassword">Confirm
                                    password</label>
                                <input type="password" name="confirmpassword" id="confirmpassword"
                                    class="form-control register__box-body--input">
                                    <span class="text-danger error-message"><?php echo $data['confirm_password_err']; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="signup" id="signup" value="Sign Up"
                                    class="btn btn-primary register__box-body--btn">
                            </div>
                            <a href="<?php echo URL_ROOT?>users/login" class="register__box-body--link" id="signIn-link">Already have an
                                account ? Sign in here</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once "../app/views/layouts/footer.php"; ?>