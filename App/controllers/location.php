<?php

class location extends Controller{
    private $incomingData = [];
    private $tid;

    public function index($data)
    {
        $this->incomingData = $data;
        if(!empty($this->incomingData['longitude']) && !empty($this->incomingData['latitude'])){
            $this->checkvertid($this->incomingData["tid"]);
            if($this->incomingData["statustid"]=="OK"){
                $this->tid = $this->incomingData["vertid"];
                if($this->model('Location_model')->insertData($this->incomingData)>0){
                    return $this->view('send_message')->index("SUCCESS 07", $this->incomingData);
                }
            }
            else{
                return $this->view('send_message')->index($this->incomingData["statustid"], $this->incomingData);
            }
        }
        else{
            return $this->view('send_message')->index("FAILED 13", $this->incomingData);
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
                    $this->incomingData["statustid"]="OK";    
                    return $this->incomingData;
                }
                else{
                    $this->incomingData["statustid"]="FAILED 10";
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
