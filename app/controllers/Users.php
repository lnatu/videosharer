<?php

class Users extends Controller {

    public function __construct() {

        if (isLoggedIn()) {
            flash('login_message', 'You\'re already logged in');
            redirect();
        }
        $this -> userModel = $this -> model('User');
        $this -> commentModel = $this -> model('Comment');
    
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'first_name' => trim($_POST['firstname']),
                'last_name' => trim($_POST['lastname']),
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirmpassword']),
                'profile_picture' => 'assets/img/icon/user.png',

                'first_name_err' => '',
                'last_name_err' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if (empty($data['first_name'])) { $data['first_name_err'] = 'Please enter your first name'; }
            if (empty($data['last_name'])) { $data['last_name_err'] = 'Please enter your last name'; }
            
            if (empty($data['username'])) { 
                $data['username_err'] = 'Please enter your username'; 
            } else if (strlen($data['username']) < 6) {
                $data['username_err'] = 'Your username must has at least 6 characters'; 
            }
            
            if (empty($data['email'])) { 
                $data['email_err'] = 'Please enter your email'; 
            } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a correct email'; 
            } else if ($this -> userModel -> checkEmailExist($data['email'])) {
                $data['email_err'] = 'Email already taken'; 
            }

            if (empty($data['password'])) { $data['password_err'] = 'Please enter your password'; }
            if (empty($data['confirm_password'])) { $data['confirm_password_err'] = 'Please confirm your password'; }
            if (strlen($data['password']) < 8 ) {
                $data['password_err'] = 'Password must has at least 8 characters';
            } else if ($data['password'] != $data['confirm_password']) {
                $data['password_err'] = 'Password does not match';
                $data['confirm_password_err'] = 'Password does not match';
            }

            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                if ($this -> userModel -> register($data)) {
                    flash('user_message', 'Register successful');
                    redirect('users/login');
                }
            } else {
                $this -> view('users/register', $data);
            }

        } else {
            $data = [
                'first_name' => '',
                'last_name' => '',
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'profile_picture' => '',

                'first_name_err' => '',
                'last_name_err' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this -> view('users/register', $data);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),

                'email_err' => '',
                'password_err' => ''
            ];
            
            if (empty($data['email'])) { 
                $data['email_err'] = 'Please enter your email'; 
            } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a correct email'; 
            } else if (!$this -> userModel -> checkEmailExist($data['email'])) {
                $data['email_err'] = 'Email not exist'; 
            }

            if (empty($data['password'])) { $data['password_err'] = 'Please enter your password'; }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this -> userModel -> login($data['email'], $data['password']);
                if ($loggedInUser) {
                    $this -> userModel -> createUserSession($loggedInUser);
                    redirect();
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                $this -> view('users/login', $data);
            }

        } else {
            $data = [
                'email' => '',
                'password' => '',
                
                'email_err' => '',
                'password_err' => ''
            ];
            $this -> view('users/login', $data);
        }
    }

    public function getFlash() {
        flash('user_message', 'Please log in first', 'alert alert-primary');
    }

}