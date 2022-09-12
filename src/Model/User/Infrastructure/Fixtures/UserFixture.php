<?php

declare(strict_types=1);

namespace App\Model\User\Infrastructure\Fixtures;

use App\Model\Shared\Infrastructure\Tools\FakerTools;
use App\Model\User\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends Fixture
{
    use FakerTools;

    public function __construct(private readonly UserFactory $userFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->registerUser(
            $this->getFaker()->firstName(),
            $this->getFaker()->lastName(),
            $this->getFaker()->email(),
            'password'
        );
        $user->confirmSignUp();

        $manager->persist($user);
        $manager->flush();
    }
}
