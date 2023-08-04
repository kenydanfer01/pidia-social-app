<?php

namespace SocialApp\Apps\Financiero\Webapp\Form;

use CarlosChininin\App\Infrastructure\Form\DateFlatpickrType;
use SocialApp\Apps\Financiero\Webapp\Entity\Proyeccion;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('anio', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-flatpickr',
                    'placeholder' => 'Selecciona una fecha',
                ],
                'label' => 'Año:',
            ])
            ->add('quintales')
            ->add('acopiadoQuintales')
            ->add('aporte', MoneyType::class, [
                'label' => 'Aporte:',
                'currency' => 'PEN',
            ])
            ->add('pagoAporte', MoneyType::class, [
                'label' => 'Pago Aporte:',
                'currency' => 'PEN', // Código ISO de la moneda (PEN para soles)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proyeccion::class,
        ]);
    }
}
