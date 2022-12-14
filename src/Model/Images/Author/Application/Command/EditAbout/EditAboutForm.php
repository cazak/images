<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Command\EditAbout;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditAboutForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('about', TextareaType::class, [
            'required' => false,
            'attr' => ['rows' => 6, 'placeholder' => 'About'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditAboutCommand::class,
        ]);
    }
}
