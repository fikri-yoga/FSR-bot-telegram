<?php

class Ticket_model {

    private $table = 'dd_ticket';
    private $db;
    private $tid;

    public function __construct()
    {
        $this->db = new Database;
    }

    //function to retrieve the latest id from the table
    public function getMaxId()
    {
        $query = "SELECT MAX(id) FROM ".$this->table." WHERE ticket<>''";
        
        $this->db->query($query);

        return $this->db->single();
    }

    //function to insert new data
    public function insertTicket($data)
    {
        $query = "INSERT INTO ".$this->table." (tid, status, remark, information, chat_id, from_id, chat_name, chat_type, input_date)
                        VALUES
                  (:tid, :status, :remark, :information, :chat_id, :from_id, :chat_name, :chat_type, :input_date)";

        $this->db->query($query);

        $this->db->bind('tid', $data['vertid']);
        $this->db->bind('status', $data['controller']);
        $this->db->bind('remark', $data['remark']);
        $this->db->bind('information', $data['information']);
        $this->db->bind('chat_id', $data['chatid']);
        $this->db->bind('from_id', $data['fromid']);
        $this->db->bind('chat_name', $data['chatname']);
        $this->db->bind('chat_type', $data['chattype']);
        $this->db->bind('input_date', date("Y-m-d H:i:s"));

        $this->db->execute();

        return $this->db->rowCount();   
    }

    //function to update the second ID for the first time (table is empty)
    public function UpdateSecId()
    {
        $query = "UPDATE ".$this->table." SET sec_id=1 WHERE sec_id=0";

        $this->db->query($query);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //function to update ticket column
    public function UpdateTicket($data)
    {
        $query = "UPDATE ".$this->table." SET ticket=CONCAT('FSR',DATE_FORMAT(input_date,'%Y%m%d'),'.',LPAD(sec_id,6,'0')) WHERE ticket='' and tid=:tid";

        $this->db->query($query);

        $this->db->bind('tid', $data);
        
        $this->db->execute();

        return $this->db->rowCount();
    }

    //function to take the time from the newly inserted row
    public function getInputDateNow($data)
    {
        $query = "SELECT DAY(input_date) FROM ".$this->table." WHERE id_baru=0 AND tid=:tid";

        $this->db->query($query);

        $this->db->bind('tid', $data);

        return $this->db->single();
    }

    //function to take time from the previous last line
    public function getInputDateBefore($data)
    {
        $query = "SELECT DAY(input_date) FROM ".$this->table." WHERE id=:id";

        $this->db->query($query);

        $this->db->bind('id', $data);

        return $this->db->single();
    }

    
    //function to retrieve the second ID from the previous last line
    public function getIdBaru($data)
    {
        $query = "SELECT id_baru FROM ".$this->table." WHERE id=:id";

        $this->db->query($query);

        $this->db->bind('id', $data);

        return $this->db->single();
    }

    //function to update the second ID if the table is not empty
    public function UpdateSecId_2($data)
    {
        $a = $data+1;
        
        $query = "UPDATE ".$this->table." SET sec_id=:sec_id WHERE sec_id=0";

        $this->db->query($query);

        $this->db->bind('sec_id', $a);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //function to get the number of successful reports received today
    public function getProgres($data)
    {
        $query = "SELECT COUNT(id) FROM ".$this->table." WHERE from_id=:from_id AND YEAR(input_date)=YEAR(DATE_ADD(NOW(), INTERVAL 7 HOUR)) AND MONTH(input_date)=MONTH(DATE_ADD(NOW(), INTERVAL 7 HOUR)) AND DAY(input_date)=DAY(DATE_ADD(NOW(),INTERVAL 7 HOUR))";

        $this->db->query($query);

        $this->db->bind('from_id', $data);

        return $this->db->single();
    }

    //function to check whether the TID reported has been reported today
    public function getTidToday($data)
    {
        $query = "SELECT tid FROM ".$this->table." WHERE tid=:tid AND YEAR(input_date)=YEAR(DATE_ADD(NOW(), INTERVAL 7 HOUR)) AND MONTH(input_date)=MONTH(DATE_ADD(NOW(), INTERVAL 7 HOUR)) AND DAY(input_date)=DAY(DATE_ADD(NOW(), INTERVAL 7 HOUR))";

        $this->db->query($query);

        $this->db->bind('tid', $data);

        return $this->db->single();
    }
    
    //function to display data entered on a certain date
    public function showTicket($data)
    {
        $query = "SELECT * FROM ".$this->table." WHERE YEAR(input_date)=YEAR(:tanggal) AND MONTH(input_date)=MONTH(:tanggal) AND DAY(input_date)=DAY(:tanggal)";
        
        $this->db->query($query);
        
        $this->db->bind('tanggal', $data);
        
        return $this->db->resultSet();
    }
}
