<?php

class Category {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getCategories() {
        $this->db->query("SELECT * FROM category");
        return $this->db->resultSet();
    }

}