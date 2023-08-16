<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Form;

use CarlosChininin\App\Infrastructure\Form\DateFlatpickrType;
use SocialApp\Apps\Salud\Webapp\Entity\Paciente;
use SocialApp\Apps\Salud\Webapp\Entity\RegistroFondos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroFondosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', TextType::class, [
                'label' => 'Número de DNI:  ',
            ])
            ->add('nombreSocio', TextType::class, [
                'label' => 'Nombre Encontrado:  ',
            ])
            ->add('baseSocial', TextType::class, [
                'label' => 'Base Social:  ',
            ])
            ->add('tipoSocio', TextType::class, [
                'label' => 'Tipo de Beneficiario:  ',
            ])
            ->add('tipoRegistro', ChoiceType::class, [
                'placeholder' => 'Seleccione el tipo ..',
                'choices' => [
                    'Fondo Mortorio' => 'fondomortorio',
                    'Apoyo Salud' => 'apoyosalud',
                ],
            ])
            ->add('condicion')
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-flatpickr',
                    'placeholder' => 'Selecciona una fecha',
                ],
                'label' => 'Fecha:',
            ])
            ->add('monto')
            ->add('observacion');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistroFondos::class,
        ]);
    }
}
