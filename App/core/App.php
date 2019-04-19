<?php

   class App{
        protected $update,
                  $data,
                  $controller;
              
        public function __construct($chatid=0,
              $fromid=0,
              $messageid=0,
              $chatname='',
              $chattype='',
              $pesan='',
              $command='',
              $remark='',
              $information='')
        {
            $this->data["chatid"] = $chatid;
            $this->data["fromid"] = $fromid;
            $this->data["messageid"] = $messageid;
            $this->data["chatname"] = $chatname;
            $this->data["chattype"] = $chattype;
            $this->data["message"] = $message;
            $this->data["command"] = $command;
            $this->data["remark"] = $remark;
            $this->data["information"] = $information;
        }
        
        //retrieve data from the telegram
        public function getData($update)
        {
            //retrieve chat data and store it in variables 
            $this->data["chatid"]=$update["message"]["chat"]["id"];
            $this->data["fromid"]=$update["message"]["from"]["id"];
            $this->data["messageid"]=$update["message"]["message_id"];
            $this->data["chatname"]=$update["message"]["from"]["first_name"];
            $this->data["chattype"]=$update["message"]["chat"]["type"];
            $this->data["pesan"]=$update["message"]["text"];
            
            //check whether there is location data from the incoming data
            if(!empty($update["message"]["reply_to_message"]["location"]["longitude"])){
                $this->data["longitude"]=$update["message"]["reply_to_message"]["location"]["longitude"];
                $this->data["latitude"]=$update["message"]["reply_to_message"]["location"]["latitude"];
            }
            else{
                $this->data["longitude"]=NULL;
                $this->data["latitude"]=NULL;
            }
            
            //check whether the user who sent the data is valid
            require_once 'app/core/Controller.php';
            $this->user = new controller;
            $this->data["user"]= $this->user->model('User_model')->cekUser($this->data["fromid"]);

            //if the user is valid
            if(($this->data["fromid"]==$this->data["user"][0]["from_id"]) && ($this->data["chatid"]==$this->data["user"][0]["chat_id"])){
                
                //if there is "/" character at the beginning of the chat as a marker that the message displayed is a command
                if ($this->left($this->data["pesan"], 1)=="/"){
                    $this->data["pesan"]=$this->checkChar($this->data["pesan"]);
                    $this->data["command"]=$this->parseData($this->data["pesan"])[0];
                    $this->data["command"]=$this->fixChar($this->data["command"]);
                    $this->checkCommand($this->data["command"]);
                    
                    //if the command is on the command list
                    if($this->data["statuscommand"]=="OK"){
                        
                        //check whether there is a file with the same name as the command name
                        if(file_exists('app/controllers/'.$this->data["command"].'.php')){
                            $this->controller = $this->data["command"];
                            $this->data["controller"]=$this->controller;    
                        }
                        
                        //initiates the controller with the name according to the name of the command entered
                        require_once 'app/controllers/' . $this->controller . '.php';
                        $this->controller = new $this->controller;
                        return $this->controller->index($this->data);

                    }
                    else{
                        //if the command entered is incorrect then send an error message
                        require_once 'app/core/Controller.php';
                        $this->tampilan = new controller;
                        return $this->tampilan->view('send_message')->index($this->data["statuscommand"], $this->data);
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

        //get the leftmost character from the input data
        public function left($str, $length)
        {
            return substr($str, 0, $length);
        }

        //eliminate all characters that are not needed except "_" dan "/"
        public function checkChar($str)
        {
            return preg_replace('/[^a-zA-Z0-9 _\/\']/', '', $str);

        }

        //parsing data from the command
        public function parseData($str)
        {
            return  explode('_', ltrim($str, '/'));
        }

        //remove spaces in the command and remark
        public function fixChar($str)
        {
            return strtolower(str_replace(' ', '', $str));
        }

        //check the type of command and its validity
        public function checkCommand($str)
        {
            switch ($str){
                case "done":
                    if(isset($this->parseData($this->data["message"])[1])){
                        $this->data["tid"]=$this->parseData($this->data["message"])[1];
                        $this->data["tid"]=$this->fixChar($this->data["tid"]);
                        $this->data["statuscommand"]=$this->checkTid($this->data["tid"]);
                        return $this->data;
                    }
                    else{
                        $this->data["statuscommand"]="FAILED 05";
                        return $this->data; 
                    }
                    break;
                case "tindaklanjut":
                    $messageCount = count($this->parseData($this->data["message"]));
                    if($messageCount>=3){
                        $this->data["tid"]=$this->parseData($this->data["pesan"])[1];
                        $this->data["tid"]=$this->fixChar($this->data["tid"]);
                        $this->data["statuscommand"]=$this->checkTid($this->data["tid"]);
                        if($this->data["statuscommand"]=="OK"){
                            $this->data["remark"]=$this->parseData($this->data["message"])[2];                
                            $this->data["remark"]=$this->fixChar($this->data["remark"]);
                            if(isset($this->parseData($this->data["message"])[3])){
                                $this->data["information"] = $this->parseData($this->data["message"])[3];
                                if($messageCount>4){
                                    for($i=4;$i<=$messageCount-1;$i++){
                                        $this->data["information"] .= " " . $this->parseData($this->data["message"])[$i];
                                    }
                                }
                            }
                        }
                        return $this->data;
                    }
                    else{
                        $this->data["statuscommand"]="FAILED 04";
                    }
                    break;
                case "progress":
                    $this->data["statuscommand"]="OK";
                    return $this->data;
                    break;
                case "imei":
                    $messageCount = count($this->parseData($this->data["message"]));
                    if($messageCount>=3){    
                        $this->data["tid"]=$this->parseData($this->data["message"])[1];
                        $this->data["tid"]=$this->fixChar($this->data["tid"]);
                        $this->data["statuscommand"]=$this->cekTid($this->data["tid"]);
                        if($this->data["statuscommand"]=="OK"){
                            $this->data["imei"]=$this->parseData($this->data["message"])[2];
                            $this->data["statuscommand"]=$this->checkImei($this->data["imei"]);
                            return $this->data;
                        }
                        else{
                            return $this->data["statuscommand"]="FAILED 01";
                        }
                    }
                    else{
                        $this->data["statuscommand"]="FAILED 07";
                        return $this->data; 
                    }                    
                    break;
                case "simcard":
                    $messageCount = count($this->parseData($this->data["message"]));
                    if($messageCount>=3){    
                        $this->data["tid"]=$this->parseData($this->data["message"])[1];
                        $this->data["tid"]=$this->fixChar($this->data["tid"]);
                        $this->data["statuscommand"]=$this->cekTid($this->data["tid"]);
                        if($this->data["statuscommand"]=="OK"){
                            $this->data["simcard"]=$this->parseData($this->data["message"])[2];
                            $this->data["statuscommand"]=$this->checkSimcard($this->data["simcard"]);
                            return $this->data;
                        }
                        else{
                            return $this->data["statuscommand"]="FAILED 01";
                        }
                    }
                    else{
                        $this->data["statuscommand"]="FAILED 08";
                        return $this->data; 
                    }                    
                    break;
                case "checktid":    
                    if(isset($this->parseData($this->data["message"])[1])){
                        $this->data["tid"]=$this->parseData($this->data["message"])[1];
                        $this->data["tid"]=$this->fixChar($this->data["tid"]);
                        $this->data["statuscommand"]=$this->checkTid($this->data["tid"]);
                        return $this->data;
                    }
                    else{
                        $this->data["statuscommand"]="FAILED 09";
                        return $this->data;
                    }
                    break;
                case "location":
                    if(isset($this->parseData($this->data["message"])[1])){
                        $this->data["tid"]=$this->parseData($this->data["message"])[1];
                        $this->data["tid"]=$this->fixChar($this->data["tid"]);
                        $this->data["statuscommand"]=$this->checkTid($this->data["tid"]);
                        return $this->data;
                    }
                    else{
                        $this->data["statuscommand"]="FAILED 12";
                        return $this->data;
                    }
                    break;
                case "getlocation":    
                    if(isset($this->parseData($this->data["message"])[1])){
                        $this->data["tid"]=$this->parseData($this->data["message"])[1];
                        $this->data["tid"]=$this->fixChar($this->data["tid"]);
                        $this->data["statuscommand"]=$this->checkTid($this->data["tid"]);
                        return $this->data;
                    }
                    else{
                        $this->data["statuscommand"]="FAILED 14";
                        return $this->data;
                    }
                    break;
                case "help":
                    $this->data["statuscommand"]="OK";
                    return $this->data;
                    break;                    
                default:
                    $this->data["statuscommand"]="";
                    return $this->data;
            }
        }
        
        //check whether the TID entered is an 8 digit number
        public function checkTid($str)
        {
            if(strlen($str)==8 && is_numeric($str)==TRUE){
                return "OK";   
            }
            else{
                return "FAILED 01";            
            }
        }

        //check whether the IMEI number entered is an 8 digit number
        public function checkImei($str)
        {
            if(strlen($str)==15 && is_numeric($str)==TRUE){
                return "OK";   
            }
            else{
                return "FAILED 02";            
            }
        }

        //check whether the simcard number entered is a number
        public function checkSimcard($str)
        {
            if(is_numeric($str)==TRUE){
                return "OK";   
            }
            else{
                return "FAILED 03";            
            }
        }
   }
