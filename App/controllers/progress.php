<?php

class progress extends Controller{
    private $incomingData = [];
    private $jumlah;

    public function index($data)
    {
        $this->incomingData = $data;
        $this->count = $this->model('Tiket_model')->getProgress($this->incomingData["fromid"]);
        foreach($this->count as $count2 => $value){
            $count2 = $value;
        }
        $this->incomingData['count']=$i;
        return $this->view('send_message')->index("SUCCESS 05", $this->incomingData);
    }
}
