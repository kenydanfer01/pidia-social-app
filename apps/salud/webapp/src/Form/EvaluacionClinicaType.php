<?php

namespace SocialApp\Apps\Salud\Webapp\Form;

use Doctrine\DBAL\Types\BooleanType;
use phpDocumentor\Reflection\Types\Boolean;
use SocialApp\Apps\Salud\Webapp\Entity\EvaluacionClinica;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluacionClinicaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperaturaMaxima', TextType::class, [
                'label' => 'Temperatura Máxima',
            ])
            ->add('hasFiebre', CheckboxType::class, [
                'label' => 'Fiebre',
            ])
            ->add('hasTos', CheckboxType::class, [
                'label' => 'Tos',
            ])
            ->add('hasDolorGarganta', CheckboxType::class, [
                'label' => 'Dolor Garganta',
            ])
            ->add('hasExpectoracion', CheckboxType::class, [
                'label' => 'Expectoracion',
            ])
            ->add('hasRinorrea', CheckboxType::class, [
                'label' => 'Rinorrea',
            ])
            ->add('hasSibilancias', CheckboxType::class, [
                'label' => 'Sibilancias',
            ])
            ->add('hasCongestionFaringea', CheckboxType::class, [
                'label' => 'Congestion Faringea',
            ])
            ->add('hasMedidaTermometro', CheckboxType::class, [
                'label' => 'Medida Termometro',
            ])
            ->add('hasOtalgia', CheckboxType::class, [
                'label' => 'Otalgia',
            ])
            ->add('hasFotofobia', CheckboxType::class, [
                'label' => 'Fotofobia',
            ])
            ->add('hasCongestionConjuntiva', CheckboxType::class, [
                'label' => 'Congestion Conjuntiva',
            ])
            ->add('hasVomitos', CheckboxType::class, [
                'label' => 'Vomitos',
            ])
            ->add('hasDolorAbdominal', CheckboxType::class, [
                'label' => 'Dolor Abdominal',
            ])
            ->add('hasDiarrea', CheckboxType::class, [
                'label' => 'Diarrea',
            ])
            ->add('hasAdenopatias', CheckboxType::class, [
                'label' => 'Adenopatias',
            ])
            ->add('hasAstenia', CheckboxType::class, [
                'label' => 'Astenia',
            ])
            ->add('hasCefalea', CheckboxType::class, [
                'label' => 'Cefalea',
            ])
            ->add('hasMialgias', CheckboxType::class, [
                'label' => 'Mialgias',
            ])
            ->add('hasMalestarGeneral', CheckboxType::class, [
                'label' => 'Malestar General',
            ])
            ->add('hasErupcionDermica', CheckboxType::class, [
                'label' => 'Erupción Dérmica',
            ])
            ->add('otros', TextType::class, [
                'label' => 'OTROS',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvaluacionClinica::class,
        ]);
    }
}
