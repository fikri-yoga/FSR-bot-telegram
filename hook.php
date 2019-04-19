<?php
    require_once 'app/init.php';
    $content = file_get_contents("php://input");
    $updates = json_decode($content, true);

    $GLOBALS['pesan']=$pesan;
    $GLOBALS['fromid'] = $updates["message"]["from"]["id"];*/
    $chatid = $updates["message"]["chat"]["id"];
    $messageid = $updates["message"]["message_id"];

    $app = new App;
    $message = $app->getData($updates);
    
    $sendto = API_URL."sendmessage?chat_id=".$chatid."&text=".$message."&reply_to_message_id=".$messageid;
    file_get_contents($sendto);
