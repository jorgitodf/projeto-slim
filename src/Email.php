<?php

namespace App\Src;

use PHPMailer\PHPMailer\PHPMailer;
use App\Templates\Template;

class Email
{
    private $data;
    private $template;

    private function config()
    {
        return (object) Load::file('/config.php');
    }

    public function data(array $data)
    {
        $this->data = (object)$data;

        return $this;
    }

    public function template(Template $template)
    {
        if (!isset($this->data)) {
            throw new \Exception("Antes de chamar o template, passe os dados através do método data");
        }      
        
        $this->template= $template->run($this->data);

        return $this;
    }

    public function send()
    {
        if (!isset($this->template)) {
            throw new \Exception("Antes enviar o e-mail, escolha um template com o método template");
        }

        $mailer = new PHPmailer;

        $config = (object)$this->config()->email;

        $mailer->SMTPDebug = 2;                                 
        $mailer->isSMTP();                                     
        $mailer->Host = $config->host;  
        $mailer->SMTPAuth = true;                               
        $mailer->Username = $config->username;                
        $mailer->Password = $config->password;                           
        $mailer->SMTPSecure = 'tls';                            
        $mailer->Port = $config->port;        
        $mailer->CharSet = 'UTF-8';                            
    
        //Recipients
        $mailer->setFrom($this->data->fromEmail, $this->data->fromName);
        $mailer->addAddress($this->data->toEmail, $this->data->toName);     
    
        //Content
        $mailer->isHTML(true);                                  
        $mailer->Subject = $this->data->assunto;
        $mailer->Body    = $this->template;
        $mailer->AltBody = 'This is the body in plain text for non-HTML mailer clients';
    
        $mailer->send();
        echo 'E-mail enviado com sucesso!';

    }
}