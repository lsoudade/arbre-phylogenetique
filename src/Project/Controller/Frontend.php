<?php

namespace Project\Controller;

class Frontend extends Controller
{
    public function aboutUs()
    {
        return $this->render('Frontend/aboutUs');
    }
    
    public function termsOfService()
    {
        return $this->render('Frontend/termsOfService');
    }
    
    public function privacy()
    {
        return $this->render('Frontend/privacy');
    }
    
    public function contact()
    {
        $data = array();
        
        if ( $this->app['manager.user']->isAuthenticated() ) {
            $user = $this->app['security']->getToken()->getUser();
            $data = array(
                'user_id' => $user->getExtraField('id'),
                'email'   => $user->getExtraField('email')
            );
        }
        
        // Create form
        $form = $this->app['form.contact']->build($data);
        
        $form->handleRequest($this->request);

        if ($form->isValid()) {
                                
            if ( $this->app['manager.contact']->create($form->getData()) ) {

                // Success message
                $this->notice('Votre message a bien été envoyé.');
                
                // Send an email to admin
                $this->app['mailer']->sendContactEmail(
                    $this->render('Mail/' . $this->app['locale'] . '/contact', array('data' => $form->getData())) );

                return $this->app->redirect($this->app['url_generator']->generate('homepage'));
            }
            
            // Error message
            $this->notice("Une erreur s'est produite pendant l'envoi de votre message, veuillez réessayer.");
            
            return $this->app->redirect($this->app['url_generator']->generate('contact'));
        }
        
        // Display the form
        return $this->render('Frontend/contact', array('form' => $form->createView()));
    }
}