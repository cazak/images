<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\GetAuthors;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Form extends AbstractType
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Email',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('name', TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Name',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('nickname', TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Nickname',
            ]])
            ->add('id', ChoiceType::class, [
                'choices' => array_flip($this->getAuthorIds()),
                'required' => false,
                'placeholder' => 'Id',
                'attr' => ['onchange' => 'this.form.submit()'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    /**
     * @return array<string, string>
     * @throws Exception
     */
    private function getAuthorIds(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'id',
                'TRIM(CONCAT(name, \' \', surname)) AS name',
            ])
            ->from('images_authors')
            ->orderBy('name', 'DESC')
            ->executeQuery();

        return $stmt->fetchAllKeyValue();
    }
}
