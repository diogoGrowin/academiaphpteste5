<?php

namespace app\controller;



class mailController
{

    public function sendMail($destination, $code)
    {   
        try
        {   
            $from = ['no-reply@foundationphp.com' => 'Foundation PHP'];

            // prepare email message
            $message = new \Swift_Message();
            $message->setSubject('Registration Email');
            $message->setFrom($from);
            $message->addTo($destination);
            $message->setBody('This message was sent by new application. Copy the following code : ' . "\n\n" . 
                htmlspecialchars($code) );

            // create the transport
            $transport = new \Swift_SmtpTransport();

            $mailer = new \Swift_Mailer($transport);

            //send email
            if ($mailer->send($message))
            {
                return true;
            }else
            {
                die('Impossivel enviar email de momento !');
            }

           
        
        }catch(Exception $e)
        {
            die('Impossivel enviar email de momento ! '. $e->getMessage() );
        }
    }

}

?>