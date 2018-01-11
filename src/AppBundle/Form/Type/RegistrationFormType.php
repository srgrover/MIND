<?php

namespace AppBundle\Form\Type;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => false,
                "required" => true,
                'attr' => ['placeholder' => 'Nombre']
            ])
            ->add('apellidos', TextType::class, [
                "label" => false,
                "required" => true,
                'attr' => ['placeholder' => 'Apellidos']
            ])
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), [
                'label' => false,
                'attr' => ['placeholder' => 'form.email'],
                'translation_domain' => 'FOSUserBundle'
            ])
            ->add('username', null, [
                'label' => false,
                'attr' => ['placeholder' => 'form.username'],
                'translation_domain' => 'FOSUserBundle'
            ])
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), [
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => [
                    'translation_domain' => 'FOSUserBundle'
                ],
                'first_name' => "pass",
                'first_options' => [
                    'label' => false,
                    'attr' => ['placeholder' => 'form.password'],
                ],
                'second_name' => "repeat",
                'second_options' => [
                    'label' => false,
                    'attr' => ['placeholder' => 'form.password_confirmation'],
                ],
                'invalid_message' => 'fos_user.password.mismatch',
            ]);
    }
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
    public function getName()
    {
        return 'app_user_registration';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_usuario';
    }
}