<?php

class User_model {

    private $table = 'sd_user';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function checkUser($user)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE from_id=:from_id');
        $this->db->bind(':from_id', $user);
        return $this->db->resultSet();
    }
}
