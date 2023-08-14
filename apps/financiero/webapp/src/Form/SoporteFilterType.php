<?php

namespace SocialApp\Apps\Financiero\Webapp\Form;

use Doctrine\ORM\EntityRepository;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoSoporte;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\SoporteFilterDto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoporteFilterType extends AbstractType
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
            ->add('tipoSoporte', EntityType::class, [
                'class' => TipoSoporte::class,
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
            'data_class' => SoporteFilterDto::class,
        ]);
    }
}
