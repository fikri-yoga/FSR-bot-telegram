<?php

class problem extends Controller{
    protected $incomingData = [];
    protected $tid,
              $id;

    public function index($data)
    {
        $this->incomingData = $data;
        $this->checkvertid($this->incomingData["tid"]);
        $this->checkverremark($this->incomingData["remark"]);
        if($this->incomingData["statustid"]=="OK"){
            if(!empty($this->incomingData["verremark"])){
                    $this->tid = $this->incomingData["vertid"];
                    $maxid = $this->model('Ticket_model')->getMaxId();
                    foreach($maxid as $maxid2 => $value){
                        $maxid2 = $value;
                    }
                    if($maxid2==0){
                        if($this->model('Ticket_model')->insertTiket($this->incomingData)>0){
                            if($this->model('Ticket_model')->updateSecId()>0){
                                if($this->model('Ticket_model')->updateTicket($this->tid)>0){
                                    return $this->view('send_message')->index("SUCCESS 02", $this->incomingData);
                                }
                            }
                        }
                    }
                    else{
                        if($this->model('Ticket_model')->insertTicket($this->incomingData)>0){
                            $input_date_now = $this->model('Ticket_model')->getInputDateNow($this->tid);
                            foreach($input_date_now as $input_date_now2 =>$value){
                                $input_date_now2=$value;
                            }
                            $input_date_before = $this->model('Ticket_model')->getInputDateBefore($a);
                            foreach($input_date_before as $input_date_before2 => $value){
                                $input_date_before2 = $value;
                            }
                            if($input_date_now2==$input_date_before2){
                                $idbefore = $this->model('Ticket_model')->getMaxId();
                                foreach($idbefore as $idbefore2 => $value){
                                    $idbefore2 = $value;
                                }
                                $newmaxid = $this->model('Ticket_model')->getSecId($d);
                                foreach($newmaxid as $newmaxid2 => $value){
                                    $newmaxid2 = $value;
                                }
                                if($this->model('Ticket_model')->updateSecId_2($e)>0){
                                    if($this->model('Ticket_model')->updateTicket($this->tid)>0){
                                        return $this->view('send_message')->index("SUCCESS 02", $this->incomingData);
                                    }
                                }
                            }
                            else{
                                if($this->model('Ticket_model')->updateSecId()>0){
                                    if($this->model('Ticket_model')->updateTicket($this->tid)>0){
                                        return $this->view('send_message')->index("SUCCESS 02", $this->incomingData);
                                    }
                                }
                            }
                        }
                    }
            }
            else{
                return $this->view('send_message')->index("FAILED 04", $this->incomingData);
            }
        }
        else{
            return $this->view('send_message')->index($this->incomingData["statustid"], $this->incomingData);
        }
    }

    //check whether TID is on the list
    public function checkvertid($str)
    {
        if(!empty($this->model('Tid_model')->getTid($str)[0]["tid"])){
            $this->incomingData["vertid"] = $this->model('Tid_model')->getTid($str)[0]["tid"];
            $this->checkfromid = $this->model('Tid_model')->getTid($str)[0]["from_id"];
            $this->statustid = $this->model('Tid_model')->getTid($str)[0]["status_tid"];
            if($this->incomingData["fromid"]==$this->checkfromid){
                if($this->statustid=="1"){
                    if(!empty($this->model('Ticket_model')->getTidToday($str))){
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

    //check whether the remark is on the lists
    public function cekverremark($str)
    {
        switch($str){
            case "address not found" :
                $this->incomingData['verremark']="address not found";
                break;
            case "address does not match" :
                $this->incomingData['verremark']="address does not match";
                break;
            case "device brought by the owner" :
                $this->incomingData['verremark']="device brought by the owner";
                break;                
            case "outside the coverage area" :
                $this->incomingData['verremark']="outside the coverage area";
                break;            
            case "lost device" :
                $this->incomingData['verremark']="lost device";
                break;    
            case "device is damaged" :
                $this->incomingData['verremark']="device is damaged";
                break;                                
            case "device is being repaired" :
                $this->incomingData['verremark']="device is being repaired";
                break;                                    
            case "device has been taken" :
                $this->incomingData['verremark']="device has been taken";
                break;
            case "device is never been installed" :
                $this->incomingData['verremark']="device is never been installed";
                break;                
            case "the owner refused to check the device" :
                $this->incomingData['verremark']="the owner refused to check the device";
                break;                                
            case "customer is permanently closed" :
                $this->incomingData['verremark']="customer is permanently closed";
                break;                        
            case "customer closes when visited" :
                $this->incomingData['verremark']="customer closes when visited";
                break;                                   
            case "customer name does not match" :
                $this->incomingData['verremark']="customer name does not match";
                break;                                                
            default :
                $this->incomingData['verremark']=NULL;
                break; 
        }
        return $this->incomingData["verremark"];
    }
}
