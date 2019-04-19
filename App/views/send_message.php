<?php

class send_message {
    protected $status;
    protected $tid, $command, $remark, $information, $imei, $simcard, $chatname, $count;
    protected $message;

    public function index($status, $data)
    {
        if(!empty($data["tid"])){
            $this->tid=$data["tid"];
        }

        if(isset($data["command"])){
            $this->command = $data["command"];
        }
        
        if(isset($data["verremark"])){
            $this->remark = $data["verremark"];
        }

        if(isset($data["information"])){
            $this->information = $data["information"];
        }

        if(isset($data["imei"])){
            $this->imei = $data["imei"];
        }

        if(isset($data["simcard"])){
            $this->simcard = $data["simcard"];
        }

        if(isset($data["chatname"])){
            $this->chatname = $data["chatname"];
        }

        if(isset($data["count"])){
            $this->count = $data["count"];
        }

        if(isset($data["latitude"])){
            $this->latitude = $data["latitude"];
        }

        if(isset($data["longitude"])){
            $this->longitude = $data["longitude"];
        }
        
        if(isset($data["chatid"])){
            $this->chatid = $data["chatid"];
        }
                
        
        $this->status = $status;

        switch($this->status){
            case "SUCCESS 01" :
                $this->message = "Thank you, your report was successfully received! %0ATID : ".$this->tid."%0AStatus : ".$this->command;
                break;
            case "SUCCESS 02" :
                $this->message = "Thank you ".$this->chatname.", your report was successfully received! %0ATID : ".$this->tid."%0AStatus : ".$this->command."%0ARemark : ".$this->remark."%0AInformation : ".$this->information;
                break;
            case "SUCCESS 03" :
                $this->message = "Thank you, your report was successfully received! %0ATID : " . $this->tid."%0AIMEI : ".$this->imei;
                break;
            case "SUCCESS 04" :
                $this->message = "Thank you, your report was successfully received! %0ATID : " . $this->tid."%0ASimcard : ".$this->simcard;
                break;
            case "SUCCESS 05" :
                $this->message = "Hi ".$this->chatname.", the number of your reports today is ".$this->jumlah." tid.%0AThanks for your report..";
                break;
            case "SUCCESS 06" :
                $this->message = "Hi ".$this->chatname.", TID ".$this->tid." still be on the list that must be visited.";
                break;
            case "SUCCESS 07" :
                $this->message = "Thank you, your report was successfully received! Location data saved successfully!";
                //echo $this->message;
                break;
            case "SUCCESS 08" :
                $this->message = "This is the last location for TID ".$this->tid." :%0A%0Ahttps://www.google.com/maps/?q=".$this->latitude.",".$this->longitude;
                break;
            case "FAILED 01" :
                $this->message = "Wrong format!%0ATID must be an 8 digit number.";
                break;
            case "FAILED 02" :
                $this->message = "Wrong format!%0AIMEI must be a 15 digit number.";
                break;
            case "FAILED 03" :
                $this->message = "Wrong format!%0ASimcard must be a number.";
                break;
            case "FAILED 04" :
                $this->message = "Wrong format!%0AUse the paramaters:%0A/problem_tid_remark_information%0A%0ARemarks available :%0Aaddress not found%0Aaddress does not match%0Adevice brought by the owner%0Aoutside the coverage area%0Alost device%0Adevice is damaged%0Adevice is being repaired%0Adevice has been taken%0Adevice is never been installed%0Athe owner refused to check the device%0Acustomer is permanently closed%0Acustomer closes when visited%0Acustomer name does not match%0A%0APlease fill in the remark with one of the 13 remarks above.%0AThe report was rejected if the remark was incorrect!";
                break;
            case "FAILED 05" :
                $this->message = "Wrong format!%0AUse the parameters:%0A/done_tid%0A%0AThe report was rejected if the remark was incorrect!";
                break;
            case "FAILED 06" :
                $this->message = "Sorry, TID that is entered is not listed in the list that must be visited. Please check the TID.";
                break;                                
            case "FAILED 07" :
                $this->message = "Wrong format!%0AUse the parameters:%0A/imei_tid_imei number%0A%0AThe report was rejected if the parameters was incorrect!";
                break;                                                
            case "FAILED 08" :
                $this->message = "Wrong format!%0AUse the parameters:%0A/simcard_tid_simcard number%0A%0AThe report was rejected if the parameters was incorrect!";
                break;
            case "FAILED 09" :
                $this->message = "Wrong format!%0AUse the parameters:%0A/checktid_tid%0A%0AThe report was rejected if the parameters was incorrect!";
                break;
            case "FAILED 10" :
                $this->message = "TID ".$this->tid." has been removed from the list that must be visited.";
                break;
            case "FAILED 11" :
                $this->message = "Sorry, TID that you report is not yours";
                break;
            case "FAILED 12" :
                $this->message = "Wrong format!%0AUse the paramaters:%0A/location_tid%0A%0AThe command must be typed in the reply from a share location.%0AThe report was rejected if the parameters was incorrect!";
                break;
            case "FAILED 13" :
                $this->message = "Sorry, the commad /location_tid must be placed by replying to the share location that was previously entered";
                break;
            case "FAILED 14" :
                $this->message = "Wrong format!%0AUse the parameters:%0A/getlocation_tid%0A%0AThe report was rejected if the parameters was incorrect!";
                break;
            case "FAILED 15" :
                $this->message = "Sorry, the location for TID ".$this->tid." does not yet exist in the database.";
                break;
            case "FAILED 16" :
                $this->message = "Sorry, TID ".$this->tid." has been reported today, please report another TID.";
                break;
            default :
                $this->message = "FSR-Bot v1.0.%0A%0ACommand lists:%0A/done -> for successful visit reports%0A/problem -> for unsuccessful visit reports%0A/progress -> for checking the number of successful reports received today%0A/imei -> for reporting imei number%0A/simcard -> for reporting simcard number%0A/location -> for reporting the location of the customer%0A/getlocation -> for geting a customer's location that has been previously stored%0A/checktid -> for checking whether the customer still needs to be visited%0A%0ACopyright @2018 - Fikri Yoga -";
                break;
        }
        return $this->message;
    }
}
