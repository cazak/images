<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Service;

interface Assert
{
    public function notEmpty($value): void;
}
