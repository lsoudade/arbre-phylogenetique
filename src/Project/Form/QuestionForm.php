<?php

namespace Project\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

class QuestionForm extends Form
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
            'label'       => 'form.question.title',
            'attr'        => array('class' => 'form-control'),
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min'        => 10,
                    'minMessage' => 'Votre question est trop courte',
                    'max'        => 255,
                    'maxMessage' => 'form.error.question.title.maxlength'
                )),
                new Assert\Callback(array(array($this, 'uniqueQuestion')))
            )
        ))
        ->add('content', 'textarea', array(
            'required'    => false,
            'label'       => 'form.question.content',
            'attr'        => array('class' => 'form-control'),
        ));
        
        return $builder->getForm();
    }
    
    /**
     * Callback function testing question existence in db
     * To use as a form constraint
     * 
     * Must be public to avoid an exception
     * 
     * @param string $title Question to test in database
     * @param \Symfony\Component\Validator\ExecutionContextInterface $context
     */
    public function uniqueQuestion($title, ExecutionContextInterface $context)
    {
        if ( $this->app['manager.question']->questionExists($title) ) {
            $context->addViolation('form.error.question.exists');
        }
    }
}