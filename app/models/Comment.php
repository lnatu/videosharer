<?php

class Comment {

    private $db;

    public function __construct() {
        $this -> db = new Database();
    }

    public function getComments($videoId) {
        $this -> db -> query("SELECT count(*) as 'count' from comments WHERE video_id=:id");
        $this -> db -> bind(":id", $videoId);
        $comments = $this -> db -> resultSingle();
        return $comments -> count;
    }

    public function getAllComments($videoId) {
        $this -> db -> query("SELECT *,
                                comments.posted_by as posterId,
                                users.Id as userId,
                                comments.created_date as commentCreated,
                                users.created_date as userCreated
                                FROM comments
                                INNER JOIN users 
                                on comments.posted_by = users.id
                                WHERE video_id=:id ORDER BY comments.created_date DESC");
        $this -> db -> bind(":id", $videoId);
        return $this -> db -> resultSet();
    }

    public function addcomment($posted_by, $video_id, $response_to, $content) {
        $this -> db -> query("INSERT INTO comments(posted_by, video_id, response_to, content) VALUES(:posted_by, :video_id, :response_to, :content)");       
        $this -> db -> bind(":posted_by", $posted_by);
        $this -> db -> bind(":video_id", $video_id);
        $this -> db -> bind(":response_to", $response_to);
        $this -> db -> bind(":content", $content);
        $this -> db -> execute();
        
        return true;
    }

}