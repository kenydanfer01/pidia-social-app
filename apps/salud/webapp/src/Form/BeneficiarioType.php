<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Form;

use Doctrine\ORM\EntityRepository;
use SocialApp\Apps\Salud\Webapp\Entity\Beneficiario;
use SocialApp\Apps\Salud\Webapp\Entity\Parametro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BeneficiarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', TextType::class, [
                'label' => 'DNI:',
                'required' => true,
            ])
            ->add('nombre', TextType::class, [
                'label' => 'Nombre Completo: ',
                'required' => true,
            ])
            ->add('direccion', TextType::class, [
                'label' => 'Dirección:',
                'required' => false,
            ])
            ->add('telefono', TextType::class, [
                'label' => 'Teléfono:',
                'required' => false,
            ])
            ->add('fechaNacimiento', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-flatpickr',
                    'placeholder' => 'Selecciona una fecha',
                ],
                'label' => 'Fecha Nacimiento:',
                'required' => false,
            ])
            ->add('baseSocial', TextType::class, [
                'label' => 'Base Social: ',
                'required' => false,
            ])
            ->add('estadoCivil', EntityType::class, [
                'class' => Parametro::class,
                'label' => 'Estado Civil:',
                'required' => false,
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
                'required' => false,
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
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('parametro')
                        ->join('parametro.parent', 'parametro_padre')
                        ->where('parametro_padre.alias = :alias')
                        ->andWhere('parametro.isActive = TRUE')
                        ->setParameter('alias', '@POSICPACI')
                        ->orderBy('parametro.name', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiario::class,
        ]);
    }
}
