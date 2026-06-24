<?php

namespace App\Form;

use App\Entity\Equipo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class InscripcionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // 1. Extraemos la variable del torneo que nos mandó el controlador
        $torneo = $options['torneo_actual'];

        $builder
            ->add('equipo', EntityType::class, [
                'class' => Equipo::class,
                'placeholder' => 'form.inscripcion.equipo_placeholder',
                'label' => 'form.inscripcion.equipo',
                'choice_label' => 'nombre',

                // 2. El QueryBuilder inteligente con la lógica de conjuntos
                'query_builder' => function (EntityRepository $er) use ($torneo) {
                    // Si por alguna razón no llega el torneo, mostramos todo por seguridad
                    if (!$torneo) {
                        return $er->createQueryBuilder('e')->orderBy('e.nombre', 'ASC');
                    }

                    // Filtramos: equipos donde este torneo NO sea miembro de su lista
                    return $er->createQueryBuilder('e')
                        ->where(':torneo NOT MEMBER OF e.torneos')
                        ->setParameter('torneo', $torneo)
                        ->orderBy('e.nombre', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // 3. Le decimos a Symfony que este formulario acepta la opción 'torneo_actual'
        $resolver->setDefaults([
            'torneo_actual' => null,
        ]);
    }
}
