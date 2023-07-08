<?php

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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichaEvaluacion::class,
        ]);
    }
}
