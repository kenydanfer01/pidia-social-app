<?php

namespace SocialApp\Apps\Salud\Webapp\Form;

use SocialApp\Apps\Salud\Webapp\Entity\ExamenFisico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamenFisicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('peso')
            ->add('talla')
            ->add('presionArterial')
            ->add('frecuenciaCardiaca')
            ->add('temperatura')
            ->add('frecuenciaRespiratoria')
            ->add('imc')
            ->add('observaciones')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExamenFisico::class,
        ]);
    }
}
