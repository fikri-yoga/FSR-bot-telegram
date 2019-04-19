<?php

class Tid_model {

    private $table = 'sd_tid';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getTid($tid)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE tid=:tid');
        $this->db->bind(':tid', $tid);
        return $this->db->resultSet();
    }
    
}
