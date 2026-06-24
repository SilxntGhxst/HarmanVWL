<?php

namespace App\Form;

use App\Entity\Equipo;
use App\Entity\Jugador;
use App\Enum\RangoJugador;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class JugadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', null, ['label' => 'form.jugador.nickname'])
            ->add('edad', null, ['label' => 'form.jugador.edad'])
            ->add('email', null, ['label' => 'form.jugador.email'])
            ->add('rango', EnumType::class,
                [
                'class' => RangoJugador::class,
                'placeholder' => 'form.jugador.rango_placeholder',
                'label' => 'form.jugador.rango',
                'choice_label'=> function($choice){
                return $choice->value;
                }]

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jugador::class,
            'attr' => ['novalidate'=>'novalidate'],
        ]);
    }
}
