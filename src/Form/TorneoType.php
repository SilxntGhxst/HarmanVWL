<?php

namespace App\Form;

use App\Entity\Equipo;
use App\Entity\Torneo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Enum\EstadoTorneo;

class TorneoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, ['label' => 'form.torneo.nombre'])
            ->add('juego', null, ['label' => 'form.torneo.juego'])
            ->add('bolsa_premios', null, ['label' => 'form.torneo.bolsa_premios'])
            ->add('estado', EnumType::class, [
                'class' => EstadoTorneo::class,
                'placeholder' => 'form.torneo.estado_placeholder',
                'label' => 'form.torneo.estado',
                // Esta pequeña función extrae el texto legible del Backed Enum
                'choice_label' => function ($choice) {
                    return $choice->value;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Torneo::class,
        ]);
    }
}
