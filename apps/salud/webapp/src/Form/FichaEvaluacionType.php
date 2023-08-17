<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Form;

use SocialApp\Apps\Salud\Webapp\Entity\EnfermedadAsociada;
use SocialApp\Apps\Salud\Webapp\Entity\FichaEvaluacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichaEvaluacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('diagnostico')
            ->add('intervenciones')
            ->add('tratamiento')
            ->add('paciente')
            ->add('enfermedadesAsociadas', EntityType::class, [
                'class' => EnfermedadAsociada::class,
                'multiple' => true,
                'required' => false,
            ])
            ->add('examenFisico', ExamenFisicoType::class, [
                'required' => false,
            ])
            ->add('evaluacionClinica', EvaluacionClinicaType::class, [
                'required' => false,
            ])
            ->add('dni')
            ->add('nombreSocio')
            ->add('baseSocial')
            ->add('tipoSocio');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichaEvaluacion::class,
        ]);
    }
}
