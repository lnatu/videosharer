<?php

class Watch extends Controller {

    public function __construct() {
        $this -> videoModel = $this -> model('Video');
        $this -> subscribeModel = $this -> model('Subscribe');
        $this -> commentModel = $this -> model('Comment');
    }

    public function index() {
        if (isset($_GET['v'])) { 
            $video_id =  $_GET['v']; 
        } 

        $video = $this -> videoModel -> getVideoById($video_id);

        if ($video) {

            $this -> videoModel -> inscreaseView($video_id);
            $totalComments = $this -> commentModel -> getComments($video_id);
            $allComments = $this -> commentModel -> getAllComments($video_id);
            $totalLikes = $this -> videoModel -> getVideoLikes($video_id);
            $totalDislikes = $this -> videoModel -> getVideoDislikes($video_id);
            $channelName = $video -> first_name . ' ' . $video -> last_name;
            $publishDate = formatDate($video -> created_date);
            $totalSubcribers = $this -> subscribeModel -> getChannelSubscribers($video->uploadedBy);

            $uploadedBy = $video -> uploadedBy;

            if (isset($_SESSION['user_id'])) {
                $currentUser = $_SESSION['user_id'];
                if ($this -> subscribeModel -> checkSubscribe($currentUser, $uploadedBy) == 0) {
                    $subscribeClass = 'subscribe';
                } else {
                    $subscribeClass = 'subscribed';
                }
                if ($this -> videoModel -> isOwner($uploadedBy, $currentUser)) {
                    $subscribeClass = 'edit';
                    $totalSubcribers = '';
                }
                $isLiked = $this -> videoModel -> isLiked($video_id, $currentUser);
                $isDisliked = $this -> videoModel -> isDisliked($video_id, $currentUser);
                $data = [
                    'video' => $video, 
                    'total_likes' => $totalLikes, 
                    'total_dislikes' => $totalDislikes,
                    'channel_name' => $channelName,
                    'publish_date' => $publishDate,
                    'subscribeClass' => $subscribeClass,
                    'totalSubs' => $totalSubcribers,
                    'totalComments' => $totalComments,
                    'allComments' => $allComments,
                    'isLiked' => $isLiked,
                    'isDisliked' => $isDisliked
                ];
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
            } else {
                $data = [
                    'video' => $video, 
                    'total_likes' => $totalLikes, 
                    'total_dislikes' => $totalDislikes,
                    'channel_name' => $channelName,
                    'publish_date' => $publishDate,
                    'subscribeClass' => 'subscribe',
                    'totalSubs' => $totalSubcribers,
                    'totalComments' => $totalComments,
                    'allComments' => $allComments,
                    'isLiked' => '',
                    'isDisliked' => ''
                ];
            }

            $this -> view('videos/watch', $data);
        } else {
            $this -> view('errors/unavailable');
        }
        
    }

}