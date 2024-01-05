<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Job;
use App\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('age')
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'designation',
            ])
            ->add('hobbies', EntityType::class, [
                'class' => Hobby::class,
                'choice_label' => 'designation',
                'multiple' => true,
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-danger']
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
