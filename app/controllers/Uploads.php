<?php

class Uploads extends Controller {

    public function __construct() {
        
        if(!isLoggedIn()) {
            flash('login_message', 'Please log in first', 'alert alert-primary');
            redirect();
        }
     
        $this -> categoryModel = $this -> model('Category');
        $this -> uploadModel = $this -> model('Upload');
        $this -> videoModel = $this -> model('Video');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'file' => $_FILES['file'],
                'title' => trim($_POST['title']),
                'uploadedBy' => $_SESSION['user_id'],
                'description' => trim($_POST['description']),
                'status' => trim($_POST['status']),
                'category' => trim($_POST['category'])
            ];
            if ($this -> uploadModel -> uploadVideo($data)) {
                flash('upload_feedback', 'Upload successful');
                redirect('uploads');
            } else {
                flash('upload_feedback', 'Could not upload video', 'alert alert-danger');
                redirect('uploads');
            }
        } else {
            $categories = $this -> categoryModel -> getCategories();
            $data = ['categories' => $categories];
            $this->view('videos/upload', $data);
        }
    }

}