<?php
/**
 * Created by PhpStorm.
 * User: texas
 * Date: 3/21/18
 * Time: 8:55 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('projects', ChoiceType::class, [
                    'attr' => ['class' => 'projects-list'],
                    'choices' => [
                        'Item 1' => '1',
                        'Item 2' => '2',
                        'Item 3' => '3'
                    ]
            ])->getForm();
    }
}