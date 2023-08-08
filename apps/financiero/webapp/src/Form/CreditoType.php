<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Form;

use SocialApp\Apps\Financiero\Webapp\Entity\Credito;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoCredito;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('socio', EntityType::class, [
                'class' => Socio::class,
                'label' => 'Socio:',
                'placeholder' => 'Seleccione..',
            ])
            ->add('tipoCredito', EntityType::class, [
                'class' => TipoCredito::class,
                'label' => 'Tipo Credito:',
                'placeholder' => 'Seleccione..',
            ])
            ->add('monto', MoneyType::class, [
                'label' => 'Monto:',
                'currency' => 'PEN',
            ])
            ->add('amortizacion', MoneyType::class, [
                'label' => 'Amortización:',
                'currency' => 'PEN',
                'required' => false,
            ])
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-flatpickr',
                    'placeholder' => 'Selecciona una fecha',
                ],
                'label' => 'Fecha:',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credito::class,
        ]);
    }
}
