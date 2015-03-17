<?php

namespace Project\Form;

use Symfony\Component\Validator\Constraints as Assert;


class AnswerForm extends Form
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
        ->add('content', 'textarea', array(
            'required'    => true,
            'label'       => 'form.answer.content',
            'attr'        => array('class' => 'form-control'),
            'constraints' => array(
                new Assert\NotBlank(),
            )
        ));
        
        return $builder->getForm();
    }
}