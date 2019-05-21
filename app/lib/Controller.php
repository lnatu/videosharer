<?php
/**
 * Base controller
 * Loads models and views
 */

 class Controller {
     
    // Load model 
    public function model($model) {
        // Require model file
        require_once '../app/models/'.$model.'.php';

        // new Model
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        // check view exits
        if (file_exists('../app/views/'.$view.'.php')) {
            require_once '../app/views/'.$view.'.php';
        } else {
            die($view.' does not exits');
        }
    }

 }