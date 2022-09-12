<?php

declare(strict_types=1);

namespace App\Model\Shared\Infrastructure\Tools;

use Faker\Factory;
use Faker\Generator;

trait FakerTools
{
    private function getFaker(): Generator
    {
        return Factory::create();
    }
}
