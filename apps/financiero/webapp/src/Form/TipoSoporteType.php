<?php

namespace SocialApp\Apps\Financiero\Webapp\Form;

use SocialApp\Apps\Financiero\Webapp\Entity\TipoCredito;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoCreditoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre:',
                'required' => false,
            ])
            ->add('codigoCuenta', TextType::class, [
                'label' => 'Codigo de cuenta:',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TipoCredito::class,
        ]);
    }
}
