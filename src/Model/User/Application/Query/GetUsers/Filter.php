<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUsers;

final class Filter
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $role = null;
    public ?string $email = null;
    public ?string $nickname = null;
}
