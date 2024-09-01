<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ResumeSendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'mapped' => false,
                'label' => "Send to company",
            ])
            ->add('send', SubmitType::class)
        ;
    }
}