<?php

namespace App\Model\User\Domain\Service;

interface ConfirmTokenGenerator
{
    public function generate(): string;
}
