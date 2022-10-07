<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_heure_depart', DateTimeType::class, [
                'years' => range(2022, 2040),
                'hours' => range(8, 20),
                'label'=> 'Date / Heure de départ'
            ])
            ->add('date_heure_fin', DateTimeType::class, [
                'years' => range(2022, 2040),
                'hours' => range(8, 20),
                'label'=> 'Date / Heure de fin'
            ])
            // ->add('prix_total')
            // ->add('date_enregistrement')
            // ->add('vehicule')
            // ->add('membre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
