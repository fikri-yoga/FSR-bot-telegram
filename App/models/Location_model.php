<?php

class Location_model {
    private $table = 'dd_location';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //function to insert new data
    public function insertData($data)
    {
        $query = "INSERT INTO ".$this->table." (tid, longitude, latitude, chat_id, from_id, chat_name, chat_type, input_date) VALUES (:tid, :longitude, :latitude, :chat_id, :from_id, :chat_name, :chat_type, :input_date)";

        $this->db->query($query);
                
        $this->db->bind('tid', $data['vertid']);
        $this->db->bind('longitude', $data['longitude']);
        $this->db->bind('latitude', $data['latitude']);
        $this->db->bind('chat_id', $data['chatid']);
        $this->db->bind('from_id', $data['fromid']);
        $this->db->bind('chat_name', $data['chatname']);
        $this->db->bind('chat_type', $data['chattype']);
        $this->db->bind('input_date', date("Y-m-d H:i:s"));

        $this->db->execute();

        return $this->db->rowCount();
    }

    //function to get the latest location for the device
    public function getLocation($data){
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE tid=:tid');
        $this->db->bind(':tid', $data);
        return $this->db->resultSet();
    }
}
