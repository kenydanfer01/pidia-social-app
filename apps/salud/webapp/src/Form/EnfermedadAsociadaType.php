<?php

namespace SocialApp\Apps\Salud\Webapp\Form;

use SocialApp\Apps\Salud\Webapp\Entity\EnfermedadAsociada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnfermedadAsociadaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EnfermedadAsociada::class,
        ]);
    }
}
