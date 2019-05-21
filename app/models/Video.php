<?php

class Video {

    private $db;

    public function __construct() {
        $this -> db = new Database();
    }

    public function getVideoById($id) {
        $this -> db -> query("SELECT *, 
                                video.id as videoId, 
                                users.id as userId 
                                FROM video 
                                INNER JOIN users 
                                ON video.uploadedBy = users.id WHERE video.id=:id");
        $this -> db -> bind(":id", $id);

        return $this -> db -> resultSingle();
    }

    public function isOwner($uploadedBy, $userId) {
        return $uploadedBy == $userId;
    }

    public function inscreaseView($videoId) {
        $this -> db -> query("UPDATE video SET views=views+1 WHERE id=:id");
        $this -> db -> bind(":id", $videoId);
        $this -> db -> execute();
    }

    public function getVideoLikes($id) {
        $this -> db -> query("SELECT count(*) as 'count' FROM likes WHERE video_id=:video_id");
        $this -> db -> bind(":video_id", $id);
        $totalLikes = $this -> db -> resultSingle();

        return $totalLikes -> count;
    }

    public function getVideoDislikes($id) {
        $this -> db -> query("SELECT count(*) as 'count' FROM dislikes WHERE video_id=:video_id");
        $this -> db -> bind(":video_id", $id);
        $totalLikes = $this -> db -> resultSingle();

        return $totalLikes -> count;
    }

    public function like($videoId, $userId) {

        if ($this -> isLiked($videoId, $userId)) {
            // user has already like video 
            $this -> db -> query("DELETE FROM likes WHERE user_id=:user_id AND video_id=:video_id");
            $this -> db -> bind(":user_id", $userId);
            $this -> db -> bind(":video_id", $videoId);
            $this -> db -> execute();

            $result = [
                "likes" => -1,
                "dislikes" => 0,
                "liked" => false
            ];

            return json_encode($result);

        } else {
            // user hasn't liked video
            $this -> db -> query("DELETE FROM dislikes WHERE user_id=:user_id AND video_id=:video_id");
            $this -> db -> bind(":user_id", $userId);
            $this -> db -> bind(":video_id", $videoId);
            $this -> db -> execute();
            $count = $this -> db -> rowCount();

            $this -> db -> query("INSERT INTO likes(user_id, video_id) VALUES(:user_id, :video_id)");
            $this -> db -> bind(":user_id", $userId);
            $this -> db -> bind(":video_id", $videoId);
            $this -> db -> execute();

            $result = [
                "likes" => 1,
                "dislikes" => 0 - $count,
                "liked" => true
            ];

            return json_encode($result);
        } 
    }

    public function dislike($videoId, $userId) {

        if ($this -> isDisliked($videoId, $userId)) {
            // user has already like video 
            $this -> db -> query("DELETE FROM dislikes WHERE user_id=:user_id AND video_id=:video_id");
            $this -> db -> bind(":user_id", $userId);
            $this -> db -> bind(":video_id", $videoId);
            $this -> db -> execute();

            $result = [
                "likes" => 0,
                "dislikes" => -1,
                "disliked" => false
            ];

            return json_encode($result);

        } else {
            // user hasn't liked video
            $this -> db -> query("DELETE FROM likes WHERE user_id=:user_id AND video_id=:video_id");
            $this -> db -> bind(":user_id", $userId);
            $this -> db -> bind(":video_id", $videoId);
            $this -> db -> execute();
            $count = $this -> db -> rowCount();

            $this -> db -> query("INSERT INTO dislikes(user_id, video_id) VALUES(:user_id, :video_id)");
            $this -> db -> bind(":user_id", $userId);
            $this -> db -> bind(":video_id", $videoId);
            $this -> db -> execute();

            $result = [
                "likes" => 0 - $count,
                "dislikes" => 1,
                "disliked" => true
            ];

            return json_encode($result);
        } 
    }

    public function isLiked($id, $userId) {
        $this -> db -> query("SELECT * FROM likes WHERE user_id=:user_id AND video_id=:id");
        $this -> db -> bind(":user_id", $userId);
        $this -> db -> bind(":id", $id);
        $this -> db -> execute();
        return $this -> db -> rowCount() > 0;
    }

    public function isDisliked($id, $userId) {
        $this -> db -> query("SELECT * FROM dislikes WHERE user_id=:user_id AND video_id=:id");
        $this -> db -> bind(":user_id", $userId);
        $this -> db -> bind(":id", $id);
        $this -> db -> resultSingle();
        return $this -> db  -> rowCount() > 0;
    }

}