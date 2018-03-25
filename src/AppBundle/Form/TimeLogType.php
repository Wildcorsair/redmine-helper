<?php
/**
 * Created by PhpStorm.
 * User: texas
 * Date: 3/25/18
 * Time: 11:57 AM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class)
            ->add('hours', TextType::class, [
                'attr' => [
                    'class' => 'form-control control-width-10',
                    'size' => 10,
                    'max_length' => 3
                ]
            ])
            ->add('comment', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('activity', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Design'      => '8',
                    'Development' => '9',
                    'Management'  => '10',
                    'Testing'     => '11',
                ]
            ])
            ->add('overtime', CheckboxType::class, [
                'required' => false
            ])
            ->add('create', SubmitType::class, ['attr' => ['class' => 'btn btn-success']])
            ->getForm();

        $issueID = (int)$options['data']['issue_id'];

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($issueID) {
            $form = $event->getForm();

            $formOptions = [
                'attr' => ['value' => $issueID]
            ];

            $form->add('issue_id', HiddenType::class, $formOptions);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'time_log_form',
        ));
    }
}