<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Command\Create;

final class CreateAuthorCommand
{
    public string $id;
    public string $name;
    public string $surname;
    public string $nickname;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
