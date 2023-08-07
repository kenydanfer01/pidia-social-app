<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Form;

use SocialApp\Apps\Financiero\Webapp\Entity\Proyeccion;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProyeccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('socio', EntityType::class, [
                'class' => Socio::class,
                'label' => 'Socio:',
                'placeholder' => 'Seleccione..',
            ])
            ->add('quintales')
            ->add('acopiadoQuintales')
            ->add('aporte', MoneyType::class, [
                'label' => 'Aporte:',
                'currency' => 'PEN',
                'required' => false,
            ])
            ->add('pagoAporte', MoneyType::class, [
                'label' => 'Pago Aporte:',
                'currency' => 'PEN', // Código ISO de la moneda (PEN para soles)
                'required' => false,
            ])
            ->add('anio', ChoiceType::class, [
                'label' => 'Año:',
                'choices' => $this->anios(),
                'placeholder' => 'Seleccione..',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proyeccion::class,
        ]);
    }

    private function anios(): array
    {
        $anioActual = (int) date('Y');
        $anios = [];
        for ($i = $anioActual; $i >= 2020; --$i) {
            $anios[$i] = $i;
        }
        return $anios;
    }
}
