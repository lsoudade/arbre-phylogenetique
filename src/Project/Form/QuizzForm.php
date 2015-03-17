<?php

namespace Project\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Project\Form\DataTransformer\BooleanTransformer;

class QuizzForm extends Form
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
        ->add('title', 'text', array(
            'required'    => true,
            'label'       => 'Titre du quizz',
            'attr'        => array('class' => 'form-control'),
            'constraints' => array(
                new Assert\NotBlank(),
            )
        ));
        
        $builder->add($builder->create('enabled', 'checkbox', array(
            'required'    => false,
            'label'       => 'Activer',
            'attr'        => array('class' => '')
        ))->addModelTransformer(new BooleanTransformer()) );
        
        return $builder->getForm();
    }
}