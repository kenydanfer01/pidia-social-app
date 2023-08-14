<?php

namespace SocialApp\Apps\Financiero\Webapp\Form;

use Doctrine\ORM\EntityRepository;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoCredito;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\CreditoFilterDto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('socio', EntityType::class, [
                'class' => Socio::class,
                'required' => false,
                'placeholder' => 'Todos...',
                'attr' => [
                    'class' => 'js-select2 form-select',
                ],
            ])
            ->add('tipoCredito', EntityType::class, [
                'class' => TipoCredito::class,
                'required' => false,
                'placeholder' => 'Todos...',
                'attr' => [
                    'class' => 'js-select2 form-select',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreditoFilterDto::class,
        ]);
    }
}
