<?php

class Subscribes extends Controller {

    public function __construct() {
        $this -> subscribeModel = $this -> model('Subscribe');
    }

    public function subscribe() {

        $user = $_POST['user'];
        $channel = $_POST['channel'];

        if ($this -> subscribeModel -> subscribe($user, $channel)) {
            $subsCount = $this -> subscribeModel -> getChannelSubscribers($channel);
            echo json_encode([
                'class' => 'subscribed',
                'subsCount' => $subsCount
            ]);
        } else {
            $subsCount = $this -> subscribeModel -> getChannelSubscribers($channel);
            echo json_encode([
                'class' => 'subscribe',
                'subsCount' => $subsCount
            ]);
            
        }

    }

}