<?php

namespace Project\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ContactForm extends Form
{
    /**
     * Returns a form ready for use
     * 
     * @param array $data Optional datas to fill form default values
     * @return Symfony\Component\Form\Form
     */
    public function build(array $data = null)
    {
        $builder = $this->app['form.factory']->createBuilder('form', $data);
        
        $builder
        ->add('name', 'text', array(
            'required'    => true,
            'label'       => 'Votre nom',
            'attr'        => array('class' => 'form-control'),
            'constraints' => array(
                new Assert\NotBlank(),
            )
        ))
        ->add('email', 'email', array(
            'required'    => true,
            'label'       => 'Votre email (notre réponse sera envoyée à cet email)',
            'attr'        => array('class' => 'form-control'),
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Email(),
            )
        ))
        ->add('content', 'textarea', array(
            'required'    => false,
            'label'       => 'Votre message',
            'attr'        => array('class' => 'form-control'),
            'constraints' => array(
                new Assert\NotBlank(),
            )
        ))
        ->add('user_id', 'hidden');
        
        return $builder->getForm();
    }
}