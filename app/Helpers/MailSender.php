<?php
namespace Helpers;
class MailSender{
    public $subject;
    public $body;
    public $to;
    public $from;

    public function send()
    {
        $from = DEFAULT_MAIL_FROM;
        $subject = '=?UTF-8?B?' . base64_encode($this->subject) . '?=';
        $to  = $this->to;
        $message = '
<html>
<head>
  <title>Foodorder.az Müştəri xidmətləri</title>
</head>
<body>
'.$this->body.'
</body>
</html>
';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'To: '.$this->to. "\r\n";
        $headers .= 'From: Foodorder.az Müştəri xidmətləri <'.$this->from.'>' . "\r\n";
        $_SERVER["PHP_SELF"]="";
        mail($to, $subject, $message, $headers);
    }

}
?>