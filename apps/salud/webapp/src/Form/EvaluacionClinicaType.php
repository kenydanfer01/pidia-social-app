<?php

namespace SocialApp\Apps\Salud\Webapp\Form;

use SocialApp\Apps\Salud\Webapp\Entity\EvaluacionClinica;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluacionClinicaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperaturaMaxima')
            ->add('hasFiebre')
            ->add('hasTos')
            ->add('hasDolorGarganta')
            ->add('hasRinorrea')
            ->add('hasExpectoracion')
            ->add('hasSibilancias')
            ->add('hasCongestionFaringea')
            ->add('hasMedidaTermometro')
            ->add('hasOtalgia')
            ->add('hasFotofobia')
            ->add('hasCongestionConjuntiva')
            ->add('hasVomitos')
            ->add('hasDolorAbdominal')
            ->add('hasDiarrea')
            ->add('hasAdenopatias')
            ->add('hasAstenia')
            ->add('hasCefalea')
            ->add('hasMialgias')
            ->add('hasMalestarGeneral')
            ->add('hasErupcionDermica')
            ->add('otros');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvaluacionClinica::class,
        ]);
    }
}
