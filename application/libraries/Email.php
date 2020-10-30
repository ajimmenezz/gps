<?php
namespace Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email{
    private $mail;
    private $recipients;
    public function __construct(){
        $this->setConfig();
        $this->recipients = array();
    }

    // private $config = array(
    //     "host" => "mail.gpsinfinity.com",
    //     "username" => "no-reply@gpsinfinity.com",
    //     "password" => "#gps1nfinity.$",
    //     "smtpAuth" => true,
    //     "port" => 587,
    //     "name" => "GPS Infinity Global",
    //         "secure" => false,
    //         "secureMode" => ""
    // );

    private $config = array(
        "host" => "smtp.gmail.com",
        "username" => "notifications@gpsinfinity.mx",
        "password" => "8?16ochI",
        "smtpAuth" => true,
        "port" => 465,
        "name" => "Notificaciones GPS Infinity",
        "secure" => true,
        "secureMode" => "ssl"
    );


    // private $config = array(
    //     "host" => "cuernabyte.com",
    //     "username" => "prueba.infinity@cuernabyte.com",
    //     "password" => "ZS@RC*@~AHD&",
    //     "smtpAuth" => true,
    //     "port" => 465,
    //     "name" => "Notificaciones Infinity GPS - Cuernabyte",
    //     "secure" => true,
    //     "secureMode" => "ssl"
    // );
    // 26 mail.cuernabyte.com
    

    private function setConfig(){
            $config = (object) $this->config;

            $this->mail = new PHPMailer(true);
            // $this->mail->SMTPDebug = 2;
            $this->mail->IsSMTP();
            $this->mail->Host = $config->host;
            $this->mail->SMTPAuth = $config->smtpAuth;
            $this->mail->Username = $config->username; 
            $this->mail->Password = $config->password;                                  
            $this->mail->Port = $config->port; 
            $this->mail->setFrom($config->username, $config->name);

            if($config->secure){
                $this->mail->SMTPSecure = $config->secureMode;   
            }
  
            $this->mail->CharSet = 'UTF-8';
        }


    public function setSubject($subject)
    {
        $this->mail->Subject = $subject;
    }

    public function setSenderName($senderName)
    {
        $this->mail->FromName = $senderName;
    }


    public function addRecipients($recipients){
        if(is_array($recipients)){
            foreach($recipients as $address){
                $this->mail->addAddress($address);
            }
        }
        else{
            $this->mail->addAddress($recipients);
        }     
    }
    
    public function setBody($body, $isHtml = true)
    {
        $this->mail->isHTML($isHtml);
        $this->mail->Body = $body;
    }

    


    function send(){
        try{
            $this->mail->send();  
            return true;       
        }
        catch(Exception $err){
            throw new Exception($this->mail->ErrorInfo);
        }
             
    }
    
}