<?php

namespace Project\Controller;

class User extends Controller
{
    public function edit()
    {
        $user = $this->app['security']->getToken()->getUser();
        
        $level = $this->app['experience.computer']->getLevelData($user->getExtraField('experience'));
        
        return $this->render('User/edit', array('user' => $user, 'level' => $level));
    }
    
    public function editEmail()
    {
        $user    = $this->app['security']->getToken()->getUser();
        $userRec = $user->getExtra();
        
        $form = $this->app['form.email']->build(array(
            'email' => $userRec['email']
        ));
        
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            
            $userRec = array_merge($userRec, $form->getData());
            
            // Form is valid so we can update member
            $this->app['manager.user']->update(array(
                'id'    => $userRec['id'] ,
                'email' => $userRec['email']   
            ));
            
            $this->app['manager.user']->authenticate($userRec);
            
            return $this->app->redirect($this->app['url_generator']->generate('user_edit'));
        }

        // Display the form
        return $this->render('User/editEmail', array('form' => $form->createView(), 'email' => $userRec['email']));
    }
    
    public function editUsername()
    {
        $user    = $this->app['security']->getToken()->getUser();
        $userRec = $user->getExtra();
        
        $form = $this->app['form.username']->build(array(
            'username' => $userRec['username']
        ));
        
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            
            $userRec = array_merge($userRec, $form->getData());
            
            // Form is valid so we can update member
            $this->app['manager.user']->update(array(
                'id'       => $userRec['id'] ,
                'username' => $userRec['username']   
            ));
            
            $this->app['manager.user']->authenticate($userRec);
            
            $this->notice('form.account.username.success');
            
            return $this->app->redirect($this->app['url_generator']->generate('user_edit'));
        }

        // Display the form
        return $this->render('User/editUsername', array('form' => $form->createView(), 'username' => $userRec['username']));
    }
    
    public function editPassword()
    {
        $user    = $this->app['security']->getToken()->getUser();
        $userRec = $user->getExtra();
        
        $form = $this->app['form.newPassword']->build();
        
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            
            $this->app['manager.user']->newPassword($form->getData(), $user->getId());
            
            $this->app['manager.user']->authenticate($userRec);
            
            $this->notice('form.account.password.success');
            
            return $this->app->redirect($this->app['url_generator']->generate('user_edit'));
        }

        // Display the form
        return $this->render('User/editPassword', array('form' => $form->createView()));
    }
}