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
//                'query_builder' => function (EntityRepository $er) {
//                       return $er->createQueryBuilder('p')
//                                 ->where('30 > p.age')
//                                 ->orderBy('p.name', 'ASC');
//                       },
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
