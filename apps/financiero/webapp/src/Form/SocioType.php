<?php

namespace SocialApp\Apps\Financiero\Webapp\Form;

use Doctrine\ORM\EntityRepository;
use SocialApp\Apps\Financiero\Webapp\Entity\BaseSocial;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Entity\Parametro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', TextType::class, [
                'label' => 'DNI:',
                'required' => false,
            ])
            ->add('apellidoPaterno', TextType::class, [
                'label' => 'Ap. Paterno:',
                'required' => false,
            ])
            ->add('apellidoMaterno', TextType::class, [
                'label' => 'Ap. Materno:',
                'required' => false,
            ])
            ->add('nombres', TextType::class, [
                'label' => 'Nombres:',
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
            ->add('baseSocial', EntityType::class, [
                'class' => BaseSocial::class,
                'label' => 'Base Social:',
                'placeholder' => 'Seleccione..',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}
