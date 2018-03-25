<?php
/**
 * Created by PhpStorm.
 * User: texas
 * Date: 3/20/18
 * Time: 8:11 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, ['attr' => ['class' => 'form-control m-t-10']])
            ->add('_password', PasswordType::class, ['attr' => ['class' => 'form-control m-t-10']])
            ->add('login', SubmitType::class, ['attr' => ['class' => 'btn btn-primary btn-block m-t-10']])
            ->getForm();
    }
}