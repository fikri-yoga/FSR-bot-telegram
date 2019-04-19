<?php

class Simcard_model {
    private $table = 'dd_simcard';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insertData($data)
    {
        $query = "INSERT INTO ".$this->table." (tid, simcard, chat_id, from_id, chat_name, chat_type, input_date) 
                    VALUES (:tid, :simcard, :chat_id, :from_id, :chat_name, :chat_type, :input_date)";

        $this->db->query($query);
        
        $this->db->bind('tid', $data['vertid']);
        $this->db->bind('simcard', $data['simcard']);
        $this->db->bind('chat_id', $data['chatid']);
        $this->db->bind('from_id', $data['fromid']);
        $this->db->bind('chat_name', $data['chatname']);
        $this->db->bind('chat_type', $data['chattype']);
        $this->db->bind('input_date', date("Y-m-d H:i:s"));

        $this->db->execute();

        return $this->db->rowCount();
    }
}
