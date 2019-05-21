<?php

class Subscribe {

    private $db;

    public function __construct() {
        $this -> db = new Database();
    }

    public function test() {
        echo "cc";
    }

    public function checkSubscribe($user, $channel) {
        
        $this -> db -> query("SELECT * FROM subcribers WHERE user_to=:user AND user_from=:channel");
        $this -> db -> bind(":user", $user);
        $this -> db -> bind(":channel", $channel);
        $this -> db -> execute();

        return $this -> db -> rowCount();

    }

    public function subscribe($user, $channel) {
        $this -> checkSubscribe($user, $channel);
        if ($this -> checkSubscribe($user, $channel) ==  0) {
            // insert
            $this -> db -> query("INSERT INTO subcribers(user_to, user_from) VALUES(:user, :channel)");
            $this -> db -> bind(":user", $user);
            $this -> db -> bind(":channel", $channel);
            $this -> db -> execute();
            return true;
        } else {
            // delete
            $this -> db -> query("DELETE FROM subcribers WHERE user_to=:user AND user_from=:channel");
            $this -> db -> bind(":user", $user);
            $this -> db -> bind(":channel", $channel);
            $this -> db -> execute();
            return false;
        }
    }

    public function getChannelSubscribers($id) {
        $this -> db -> query("SELECT count(*) as 'count' FROM subcribers WHERE user_from=:id");
        $this -> db -> bind(":id", $id);
        $this -> db -> execute();
        $count = $this -> db -> resultSingle();

        return $count->count;
    }

}