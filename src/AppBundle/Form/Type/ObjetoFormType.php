<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetoFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                "label" => false,
                "required" => true,
                'attr' => ['placeholder' => 'Nombre']
            ])
            ->add('ubicacion', TextType::class, [
                "label" => false,
                "required" => true,
                'attr' => ['placeholder' => 'Ubicacion']
            ]);
    }

    public function getName()
    {
        return 'objeto_form_type';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Objeto'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_objeto';
    }
}