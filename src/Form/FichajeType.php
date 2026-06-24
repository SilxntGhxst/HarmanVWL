<?php
namespace App\Form;

use App\Entity\Jugador;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class FichajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jugador', EntityType::class, [
                'class' => Jugador::class,
                'placeholder' => 'form.fichaje.jugador_placeholder',
                'label' => 'form.fichaje.jugador',
                'choice_label' => 'nombre',

                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('j')
                        ->where('j.equipo IS NULL');
                },

            ])
        ;
    }
}
