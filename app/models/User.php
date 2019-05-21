<?php

class User {

    private $db;

    public function __construct() {
        $this -> db = new Database();
    }

    public function register($data) {
        $this -> db -> query("INSERT INTO users(first_name, last_name, username, email, password, profile_picture) VALUES (:first_name, :last_name, :username, :email, :password, :profile_picture)");
        $this -> db -> bind(":first_name", $data['first_name']);
        $this -> db -> bind(":last_name", $data['last_name']);
        $this -> db -> bind(":username", $data['username']);
        $this -> db -> bind(":email", $data['email']);
        $this -> db -> bind(":password", hash("sha512", $data['password']));
        $this -> db -> bind(":profile_picture", $data['profile_picture']);

        return $this -> db -> execute();
    }

    public function checkEmailExist($email) {
        $this -> db -> query("SELECT * FROM users WHERE email=:email");
        $this -> db -> bind(":email", $email);

        return $this -> db -> resultSingle();
    }

    public function checkUsernameExist($username) {
        $this -> db -> query("SELECT * FROM users WHERE username=:username");
        $this -> db -> bind(":email", $username);
        
        return $this -> db -> resultSingle();
    }

    public function login($email, $password) {
        $this -> db -> query("SELECT * FROM users WHERE email=:email");
        $this -> db -> bind(":email", $email);

        $row = $this -> db -> resultSingle();
        $hashed_password = hash("sha512", $password);
        if ($row -> password == $hashed_password) {
            return $row;
        } else {
            return false;
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user -> id;
        $_SESSION['user_email'] = $user -> email;
        $_SESSION['user_name'] = $user -> first_name.' '.$user -> last_name;
        $_SESSION['user_image'] = $user -> profile_picture;
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    public function getUserById($id) {
        $this -> db -> query("SELECT * FROM users WHERE id=:id");
        $this -> db -> bind(":id", $id);
        
        return $this -> db -> resultSingle();
    }

}