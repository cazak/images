<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUsers;

use App\Model\User\Domain\Entity\User;
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
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'User' => User::ROLE_USER,
                    'Admin' => User::ROLE_ADMIN,
                ],
                'required' => false,
                'placeholder' => 'Role',
            ])
            ->add('id', ChoiceType::class, [
                'choices' => array_flip($this->getUserIds()),
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
     * @throws Exception
     */
    private function getUserIds(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'id',
                'TRIM(CONCAT(name, \' \', surname)) AS name',
            ])
            ->from('user_users')
            ->orderBy('name', 'DESC')
            ->executeQuery();

        return $stmt->fetchAllKeyValue();
    }
}
