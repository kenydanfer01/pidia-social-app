<?php

namespace SocialApp\Apps\Salud\Webapp\Form;

use SocialApp\Apps\Salud\Webapp\Entity\EnfermedadesAsociadas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnfermedadesAsociadasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EnfermedadesAsociadas::class,
        ]);
    }
}
