<?php

namespace SocialApp\Apps\Financiero\Webapp\Form;
use CarlosChininin\App\Infrastructure\Form\DateFlatpickrType;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\EditPagoDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idPago', HiddenType::class, [
                'required' => false,
            ])
            ->add('fechaPagoEdit', DateFlatpickrType::class, [
                'required' => false,
                'label' => 'Fecha de pago:',
                'attr' => [
                    'class' => 'js-flatpickr',
                ],
            ])
            ->add('ePago', TextType::class, [
                'label' => 'Monto Pagado:',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditPagoDto::class,
        ]);
    }
}
