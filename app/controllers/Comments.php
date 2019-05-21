<?php

class Comments extends Controller {

    public function __construct() {
        $this -> commentModel = $this -> model('Comment');
        $this -> userModel = $this -> model('User');
    }

    public function getComments($videoId) {
        return $this -> commentModel -> getComments($videoId);
    }

    public function comment() {
        $userId = $_POST['userId'];
        $videoId = $_POST['videoId'];
        $responseTo = $_POST['responseTo'];
        $content = $_POST['content'];

        if ($this -> commentModel -> addcomment($userId, $videoId, $responseTo, $content)) {
            $commentCount = $this -> commentModel -> getComments($videoId);
            $user = $this -> userModel -> getUserById($userId);
            $data = [
                'totalComments' => $commentCount,
                'user' => $user,
                'comment' => $content
            ];
            echo json_encode($data);
        }

    }

}