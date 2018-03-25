<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '7']
            ])
            ->add('create', SubmitType::class, ['attr' => ['class' => 'btn btn-success']]);

        $params = $options['data'];

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($params) {
            $form = $event->getForm();

            $formOptions = [
                'attr' => ['value' => $params['project_id']]
            ];

            $authorOptions = [
                'attr' => ['class' => 'form-control', 'readonly' => 'readonly', 'value' => $params['user']]
            ];

            $form
                ->add('project_id', HiddenType::class, $formOptions)
                ->add('author', TextType::class, $authorOptions);
        });
    }
}
