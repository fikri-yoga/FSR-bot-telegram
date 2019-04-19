<?php

class done extends Controller{
    protected $incomingData = [];
    protected $tid,
              $id;

    public function index($data)
    {
        $this->incomingData = $data;
        $this->checkvertid($this->incomingData["tid"]);
        if($this->incomingData["statustid"]=="OK"){
            $this->tid=$this->incomingData["tid"];
            $maxid = $this->model('Ticket_model')->getMaxId();
            foreach($maxid as $maxid2 => $value){
                $maxid2 = $value;
            }
            if($maxid2==0){
                if($this->model('Ticket_model')->insertTicket($this->incomingData)>0){
                    if($this->model('Ticket_model')->updateSecId()>0){
                        if($this->model('Ticket_model')->updateTicket($this->tid)>0){
                            return $this->view('send_message')->index("SUCCESS 01", $this->incomingData);
                        }
                        else{
                            return NULL;
                        }
                    }
                    else{
                        return NULL;
                    }
                }
                else{
                    return NULL;
                }
            }
            else{
                if($this->model('Ticket_model')->insertTicket($this->incomingData)>0){
                    $input_date_now = $this->model('Ticket_model')->getInputDateNow($this->tid);
                    foreach($input_date_now as $input_date_now2 =>$value){
                        $input_date_now2=$value;
                    }
                    $input_date_before = $this->model('Ticket_model')->getInputDateBefore($maxid2);
                    foreach($input_date_before as $input_date_before2 => $value){
                        $input_date_before2 = $value;
                    }
                    if($input_date_before==$input_date_before2){
                        $idbefore = $this->model('Ticket_model')->getMaxId();
                        foreach($idbefore as $idbefore2 => $value){
                            $idbefore2 = $value;
                        }
                        $newmaxid = $this->model('Ticket_model')->getSecId($d);
                        foreach($newmaxid as $newmaxid2 => $value){
                            $newmaxid2 = $value;
                        }
                        if($this->model('Ticket_model')->updateSecId_2($newmaxid2)>0){
                            if($this->model('Ticket_model')->updateTicket($this->tid)>0){
                                return $this->view('send_message')->index("SUCCESS 01", $this->incomingData);
                            }
                            else{
                                return NULL;
                            }
                        }
                        else{
                            return NULL;
                        }
                    }
                    else{
                        if($this->model('Ticket_model')->updateSecId()>0){
                            if($this->model('Ticket_model')->updateTicket($this->tid)>0){
                                return $this->view('send_message')->index("SUCCESS 01", $this->incomingData);
                            }
                            else{
                                return NULL;
                            }
                        }
                        else{
                            return NULL;
                        }
                    }
                    return $this->view('send_message')->index("SUCCESS 01", $this->incomingData);                    
                }
                else{
                    return NULL;
                }
            }
        }
        else{
            return $this->view('send_message')->index($this->incomingData["statustid"], $this->incomingData);
        }
    }

    //check whether tid is on the list
    public function checkvertid($str)
    {
        if(!empty($this->model('Tid_model')->getTid($str)[0]["tid"])){
            $this->incomingData["vertid"] = $this->model('Tid_model')->getTid($str)[0]["tid"];
            $this->checkfromid = $this->model('Tid_model')->getTid($str)[0]["from_id"];
            $this->statustid = $this->model('Tid_model')->getTid($str)[0]["status_tid"];
            if($this->incomingData["fromid"]==$this->checkfromid){
                if($this->statustid=="1"){
                    $this->incomingData["checktid"]=$this->model('Ticket_model')->getTidToday($str);
                    foreach($this->datamasuk["checktid"] as $checktid => $value){
                        $checktid = $value;
                    }
                    
                    if(!empty($checktid)){
                        $this->incomingData["statustid"]="FAILED 16";
                        return $this->incomingData;                        
                    }
                    else{
                        $this->incomingData["statustid"]="OK";    
                        return $this->incomingData;
                    }
                }
                else{
                    $this->incomingData["statustid"]="FAILED 10";
                    return $this->incomingData;
                }
            }
            else{
                $this->incomingData["statustid"]="FAILED 11";
                return $this->incomingData;
            }
        }
        else{
            $this->incomingData["statustid"]="FAILED 06";
            return $this->incomingData;
        }
    }
}
