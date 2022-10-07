<?php

declare(strict_types=1);

namespace App\Security;

interface GetUserForAuthenticateFetcherInterface
{
    public function fetch(string $identifier): ?AuthUser;
}
