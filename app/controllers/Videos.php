<?php

class Videos extends Controller {

    public function __construct() {

        $this -> videoModel = $this -> model('Video');

    }

    public function like() {
        echo $this -> videoModel -> like($_POST['videoId'], $_SESSION['user_id']);
    }

    public function dislike() {
        echo $this -> videoModel -> dislike($_POST['videoId'], $_SESSION['user_id']);
    }

}