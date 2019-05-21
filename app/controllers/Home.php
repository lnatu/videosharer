<?php

class Home extends Controller {


    public function index() {
        $this -> view('home');
    }

    public function watch($id) {
        $this -> view('videos/watch');
    }

}