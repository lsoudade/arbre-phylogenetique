<?php

namespace Project\Form;

use Symfony\Component\Validator\Constraints as Assert;


class UsernameForm extends Form
{
    /**
     * Returns a form ready for use
     * 
     * @param array $data Optional datas to fill form default values
     * @return Symfony\Component\Form\Form
     */
    public function build(array $data = null)
    {
        return $this->app['form.factory']->createBuilder('form', $data)
            ->add('username', 'text', array(
                'required'    => true,
                'label'       => 'form.signup.username',
                'attr'        => array('class' => 'form-control'),
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min'        => 3,
                        'minMessage' => 'form.error.username.min'
                    )),
                    new Assert\Callback(array(array($this, 'uniqueUsername')))
                )
            ))
            ->getForm();
    }
}