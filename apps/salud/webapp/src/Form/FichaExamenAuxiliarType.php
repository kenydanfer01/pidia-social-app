<?php

namespace SocialApp\Apps\Salud\Webapp\Form;

use CarlosChininin\App\Infrastructure\Form\CollectionFormType;
use SocialApp\Apps\Salud\Webapp\Entity\ExamenAuxiliar;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliar;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliarDetalle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichaExamenAuxiliarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fichaEvaluacion')
            ->add('examenAuxiliar', EntityType::class, [
                'class' => ExamenAuxiliar::class,
                'required' => true,
                'label' => 'Examen Auxiliar:',
            ])
            ->add('detalles', CollectionFormType::class, [
                'required' => false,
                'entry_type' => FichaExamenAuxiliarDetalleType::class,
                'prototype_data' => new FichaExamenAuxiliarDetalle(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichaExamenAuxiliar::class,
        ]);
    }
}
