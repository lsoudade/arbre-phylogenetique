<?php

namespace Project\Lib;

class Mailer
{
    protected $app,
              $mailer;
    
    function __construct($app) 
    {
        $this->app = $app;
        
        // Create the Transport
        $transport = \Swift_MailTransport::newInstance();

        // Create the Mailer using your created Transport
        $this->mailer = \Swift_Mailer::newInstance($transport);
    }
    
    /**
     * Sends an email to the new member to confirm his registration
     * 
     * @param array $user Member entity as an array
     * @param string $template Twig template content used for this email
     */
    public function sendRegistrationEmail($email, $template)
    {
        // Create
        $message = \Swift_Message::newInstance($this->app['translator']->trans('mail.signup.object'))
          ->setFrom(array($this->app['parameters']['mailer']['from']))
          ->setTo(array($email))
          ->setBody($template, 'text/html');

        // Send
        return $this->mailer->send($message);
    }
    
    /**
     * Sends an email to a member to reinitialize his password
     * 
     * @param string $email User email
     * @param string $template Twig template content used for this email
     */
    public function sendLostPasswordEmail($email, $template)
    {
        // Create
        $message = \Swift_Message::newInstance($this->app['translator']->trans('mail.lost_password.object'))
          ->setFrom(array($this->app['parameters']['mailer']['from']))
          ->setTo(array($email))
          ->setBody($template, 'text/html');

        // Send
        return $this->mailer->send($message);
    }
    
    public function sendContactEmail($template)
    {
        // Create
        $message = \Swift_Message::newInstance($this->app['translator']->trans('[quizz] Contact'))
          ->setFrom(array($this->app['parameters']['mailer']['from']))
          ->setTo(array($this->app['parameters']['mailer']['admin_mail']))
          ->setBody($template, 'text/html');

        // Send
        return $this->mailer->send($message);
    }
    
    public function sendMarkedAsBestEmail($email, $template)
    {
        // Create
        $message = \Swift_Message::newInstance($this->app['translator']->trans('Votre réponse a été approuvée'))
          ->setFrom(array($this->app['parameters']['mailer']['from']))
          ->setTo(array($email))
          ->setBody($template, 'text/html');

        // Send
        return $this->mailer->send($message);
    }
    
    public function sendAnswerPostedEmail($email, $template)
    {
        // Create
        $message = \Swift_Message::newInstance($this->app['translator']->trans("Une réponse à une de vos questions vient d'être postée"))
          ->setFrom(array($this->app['parameters']['mailer']['from']))
          ->setTo(array($email))
          ->setBody($template, 'text/html');

        // Send
        return $this->mailer->send($message);
    }
}