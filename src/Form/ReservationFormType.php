<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 3, 'max' => 50]),
                    new NotBlank([
                        'message' => 'email cannot be blank.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 3, 'max' => 50]),
                    new NotBlank([
                        'message' => 'password cannot be blank.',
                    ]),
                ],
            ])
            ->add('dateFrom', DateType::class, [
                'required' => true,
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
            ])
            ->add('dateTo', DateType::class, [
                'required' => true,
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
            ])
            ->add('submit', SubmitType::class, []);;
    }
}
