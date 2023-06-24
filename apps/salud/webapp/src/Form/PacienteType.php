<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Form;

use Doctrine\ORM\EntityRepository;
use SocialApp\Apps\Salud\Webapp\Entity\BaseSocial;
use SocialApp\Apps\Salud\Webapp\Entity\Paciente;
use SocialApp\Apps\Salud\Webapp\Entity\Parametro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PacienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', TextType::class, [
                'label' => 'DNI:',
                'required' => true,
            ])
            ->add('apellidoPaterno', TextType::class, [
                'label' => 'Ap. Paterno:',
                'required' => true,
            ])
            ->add('apellidoMaterno', TextType::class, [
                'label' => 'Ap. Materno:',
                'required' => true,
            ])
            ->add('nombres', TextType::class, [
                'label' => 'Nombres:',
                'required' => true,
            ])
            ->add('direccion', TextType::class, [
                'label' => 'Dirección:',
                'required' => false,
            ])
            ->add('telefono', TextType::class, [
                'label' => 'Teléfono:',
                'required' => true,
            ])
            ->add('fechaNacimiento', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-flatpickr',
                    'placeholder' => 'Selecciona una fecha',
                ],
                'label' => 'Fecha Nacimiento:',
            ])
            ->add('estadoCivil', EntityType::class, [
                'class' => Parametro::class,
                'label' => 'Estado Civil:',
                'placeholder' => 'Seleccione..',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('parametro')
                        ->join('parametro.parent', 'parametro_padre')
                        ->where('parametro_padre.alias = :alias')
                        ->andWhere('parametro.isActive = TRUE')
                        ->setParameter('alias', '@ESTADCIVI')
                        ->orderBy('parametro.name', 'ASC');
                },
            ])
            ->add('sexo', EntityType::class, [
                'class' => Parametro::class,
                'label' => 'Sexo:',
                'placeholder' => 'Seleccione..',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('parametro')
                        ->join('parametro.parent', 'parametro_padre')
                        ->where('parametro_padre.alias = :alias')
                        ->andWhere('parametro.isActive = TRUE')
                        ->setParameter('alias', '@SEXO')
                        ->orderBy('parametro.name', 'ASC');
                },
            ])
            ->add('posicion', EntityType::class, [
                'class' => Parametro::class,
                'label' => 'Posición:',
                'placeholder' => 'Seleccione..',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('parametro')
                        ->join('parametro.parent', 'parametro_padre')
                        ->where('parametro_padre.alias = :alias')
                        ->andWhere('parametro.isActive = TRUE')
                        ->setParameter('alias', '@POSICPACI')
                        ->orderBy('parametro.name', 'ASC');
                },
            ])
            ->add('titular', EntityType::class, [
                'class' => Paciente::class,
                'placeholder' => 'Seleccione...',
                'required' => false,
            ])
            ->add('baseSocial', EntityType::class, [
                'class' => BaseSocial::class,
                'label' => 'Base Social:',
                'placeholder' => 'Seleccione..',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paciente::class,
        ]);
    }
}
