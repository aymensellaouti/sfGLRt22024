<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Person;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('people', EntityType::class, [
                'class' => Person::class,
                'choice_label' => 'name',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('p')
                        ->where('p.age <= 30')
                        ->orderBy('p.name', 'ASC');
                },
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
