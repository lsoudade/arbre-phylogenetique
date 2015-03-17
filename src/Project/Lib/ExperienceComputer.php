<?php

namespace Project\Lib;

use Project\Manager\User;

class ExperienceComputer
{
    protected $app;
    
    public function __construct($app) 
    {
        $this->app = $app;
    }
    
    public function getLevel($experience) 
    {
        foreach ( $this->app['experience']['levels'] as $level => $points ) {
            if ( $experience < $points ) {
                return $level - 1;
            }
        }
    }
    
    public function getLevelData($experience) 
    {
        $data = array('experience' => $experience);
        
        foreach ( $this->app['experience']['levels'] as $level => $points ) {
            if ( $experience < $points ) {
                $data['level'] = $level - 1;
                $data['points_max'] = $points;
                break;
            }
        }
        
        $data['points_min'] = $this->app['experience']['levels'][$data['level']];
        
        // Compute percentage
        $total       = $data['points_max'] - $data['points_min'];
        $progression = $data['experience'] - $data['points_min'];
        $data['percentage'] = $progression * 100 / $total;
        
        return $data;
    }
    
    public function compute($user_id = null)
    {
        if ( is_numeric($user_id) ) {
            $users = $this->findUserByPk($user_id);
        } else {
            $users = $this->findAllUsers();
        }
        
        foreach ( $users as $user ) {
            
            $experience = 0;
            $this->reset($user['id']);
            
            $experience += $this->findUserQuestionCount($user['id']) * User::EXPERIENCE_POINTS_QUESTION_POSTED;
            $experience += $this->findUserQuestionVoteUpCount($user['id']) * User::EXPERIENCE_POINTS_QUESTION_VOTE_UP;
            $experience += $this->findUserQuestionVoteDownCount($user['id']) * User::EXPERIENCE_POINTS_QUESTION_VOTE_DOWN;
            
            $experience += $this->findUserAnswerCount($user['id']) * User::EXPERIENCE_POINTS_ANSWER_POSTED;
            $experience += $this->findUserAnswerVoteUpCount($user['id']) * User::EXPERIENCE_POINTS_ANSWER_VOTE_UP;
            $experience += $this->findUserAnswerVoteDownCount($user['id']) * User::EXPERIENCE_POINTS_ANSWER_VOTE_DOWN;
            
            $experience += $this->findUserQuestionApprovedCount($user['id']) * User::EXPERIENCE_POINTS_ANSWER_APPROVE;
            $experience += $this->findUserAnswerApprovedCount($user['id']) * User::EXPERIENCE_POINTS_ANSWER_APPROVED;
            
            $this->update($user['id'], $experience);
        }
    }
    
    protected function sql($query)
    {
        return $this->app['manager.user']->getRepository()->query($query);
    }
    
    protected function reset($user_id)
    {
        return $this->sql('update `user` set experience = 0 where id = ' . $user_id);
    }
    
    protected function update($user_id, $experience)
    {
        return $this->sql('update `user` set experience = ' . $experience . ' where id = ' . $user_id);
    }
    
    protected function findAllUsers()
    {
        return $this->sql('select * from `user`');
    }
    
    protected function findUserByPk($user_id)
    {
        return $this->sql('select * from `user` where id = ' . $user_id);
    }
    
    protected function findUserQuestionCount($user_id)
    {
        $res = $this->sql('select COUNT(*) as nb from question where user_id = ' . $user_id . ' and enabled = 1')->fetch();
        return $res['nb'];
    }
    
    protected function findUserQuestionVoteUpCount($user_id)
    {
        $res = $this->sql('select COUNT(*) as nb from question_vote where user_id = ' . $user_id . ' and type = 1')->fetch();
        return $res['nb'];
    }
    
    protected function findUserQuestionVoteDownCount($user_id)
    {
        $res = $this->sql('select COUNT(*) as nb from question_vote where user_id = ' . $user_id . ' and type = 0')->fetch();
        return $res['nb'];
    }
    
    protected function findUserAnswerCount($user_id)
    {
        $res = $this->sql('select COUNT(*) as nb from answer where user_id = ' . $user_id . ' and enabled = 1')->fetch();
        return $res['nb'];
    }
    
    protected function findUserAnswerVoteUpCount($user_id)
    {
        $res = $this->sql('select COUNT(*) as nb from answer_vote where user_id = ' . $user_id . ' and type = 1')->fetch();
        return $res['nb'];
    }
    
    protected function findUserAnswerVoteDownCount($user_id)
    {
        $res = $this->sql('select COUNT(*) as nb from answer_vote where user_id = ' . $user_id . ' and type = 0')->fetch();
        return $res['nb'];
    }
    
    protected function findUserQuestionApprovedCount($user_id)
    {
        $res = $this->sql('select COUNT(*) as nb from question where user_id = ' . $user_id . ' and best_answer IS NOT NULL')->fetch();
        return $res['nb'];
    }
    
    protected function findUserAnswerApprovedCount($user_id)
    {
        $res = $this->sql('SELECT count(*) as nb FROM question q, answer a WHERE q.best_answer = a.id and a.user_id = ' . $user_id . ' group by a.user_id')->fetch();
        return is_numeric($res['nb']) ? $res['nb'] : 0;
    }
}