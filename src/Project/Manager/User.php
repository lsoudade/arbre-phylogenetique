<?php

namespace Project\Manager;

use \Project\Security\User as SecurityUser;

class User extends Manager
{
    const EXPERIENCE_POINTS_QUESTION_POSTED    = 5, // 
          EXPERIENCE_POINTS_QUESTION_VOTE_UP   = 1, // 
          EXPERIENCE_POINTS_QUESTION_VOTE_DOWN = 1, // 
          EXPERIENCE_POINTS_ANSWER_POSTED      = 2, // 
          EXPERIENCE_POINTS_ANSWER_VOTE_UP     = 1, //
          EXPERIENCE_POINTS_ANSWER_VOTE_DOWN   = 1, // 
          EXPERIENCE_POINTS_ANSWER_APPROVE     = 1, // 
          EXPERIENCE_POINTS_ANSWER_APPROVED    = 3; // 
    
    protected $app,
              $repository;
    
    public function __construct($app) 
    {
        $this->app            = $app;
        $this->repository     = new \Project\Repository\User($app['db']);
    }
    
    /**
     * Processes to new member creation
     * 
     * @param array $data An associative array containing new member data.
     * Mandatories array datas : 
     *  - email
     *  - pass
     * @return mixed Array of member record fields, false otherwise
     */
    public function create(array $data) 
    {
        // Prepare datas
        unset($data['rules']); // No db persistence
        $data['email'] = strtolower($data['email']);
        $data['password'] = $this->app['password']->encode($data['password']);
        $data['enabled'] = 1;
        
        // Dates
        $now = date('Y-m-d H:i:s');
        $data['created'] = $now;
        $data['updated'] = $now;

        // Create user in db
        return $this->repository->insert($data);
    }
    
    /**
     * Specifies if the given email already has an entry in member table
     * 
     * @param string $email
     * @return boolean true if email exists in database, false otherwise
     */
    public function emailExists($email)
    {
        return $this->repository->emailExists($email);
    }
    
    /**
     * Specifies if the given username already has an entry in member table
     * 
     * @param string $email
     * @return boolean true if username exists in database, false otherwise
     */
    public function usernameExists($username)
    {
        return $this->repository->usernameExists($username);
    }
    
    /**
     * Reinitialize member password in db
     * 
     * @param array $data Array containing new password
     * @param int $id Member id
     * @return boolean 
     */
    public function newPassword($data, $id) 
    {
        $data['password'] = $this->app['password']->encode($data['password']);
        
        return $this->update($data, $id);
    }
    
    /**
     * Auto-authenticates given member
     * 
     * @param array $data Array containing new password
     */
    public function authenticate($userRec)
    {
        $firewalls = array_keys($this->app['security.firewalls']);
        $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
            $userRec['email'], $userRec['password'], $firewalls[0], array('ROLE_USER'));
        $user = new SecurityUser($userRec['email'], $userRec['password'], $userRec['id'], array('ROLE_USER'));
        $user->setExtra($userRec);
        $token->setUser($user);
        $this->app['security']->setToken($token);
        
        return $userRec['enabled'] != 0;
    }
    
    /**
     * Indicates if a member is authenticated
     * 
     * @return boolean
     */
    public function isAuthenticated()
    {
        $token = $this->app['security']->getToken();
        
        if ( !is_null($token) ) {
            return ($token->getUser() instanceof SecurityUser);
        }
        
        return false;
    }
    
    /**
     * Log current member out
     * 
     * @return boolean
     */
    public function logout()
    {
        $this->app['security']->setToken(null);
    }
    
    /**
     * Get current member id
     * 
     * @return int
     */
    public function getId()
    {
        $user = $this->app['security']->getToken()->getUser();
        
        if ( is_object($user) ) {
            return $user->getId();
        }
        
        return null;
    }
    
    /**
     * Add experience points to current user
     * 
     * @return int
     */
    public function addExperience($points, $user_id = null)
    {
        if ( is_null($user_id) ) {
            $user = $this->app['security']->getToken()->getUser();
            if ( !is_object($user) ) {
                return false;
            }
            $user_id = $user->getId();
        }
        
        return $this->repository->increment('experience', $points, array(
            'id' => $user_id
        ));
    }
}