<?php

class checktid extends controller {
    protected $incomingData = [];
    protected $tid;

    public function index($data)
    {
        $this->incomingData = $data;
        $this->checkvertid($this->incomingData["tid"]);
        if($this->incomingData["statustid"]=="OK"){
            $this->tid = $this->incomingData["vertid"];
            if($this->model('Tid_model')->getStatus($this->tid)=="1"){
                return $this->view('send_message')->index("SUCCESS 06", $this->incomingData);
            }
            else{
                return $this->view('send_message')->index("FAILED 10", $this->incomingData);
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
            if($this->incomingData["fromid"]==$this->cekfromid){
                if($this->statustid=="1"){
                    $this->incomingData["statustid"]="OK";    
                    return $this->incomingData;
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
