<?php

class help extends Controller{
    private $incomingData = [];

    public function index($data)
    {
        $this->incomingData = $data;
        return $this->view('send_message')->index("", $this->incomingData);
    }
}
