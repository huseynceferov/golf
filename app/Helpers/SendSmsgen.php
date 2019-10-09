<?php
namespace Helpers;
class SendSmsgen{

    public $phone;
    public $text;

    public function send_smsgen(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://176.32.32.40/~admin/new/sms/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT , 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5); //timeout in seconds
        curl_setopt($curl, CURLOPT_POSTFIELDS, "phone=$this->phone&sms_text=$this->text");
        $response = curl_exec($curl);
        curl_close($curl);
        // }
        return $response; //	if($response == "OK"){echo "SMS gonderildi";}
    }

}
