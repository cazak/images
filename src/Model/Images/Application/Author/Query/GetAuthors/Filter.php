<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\GetAuthors;

use UnexpectedValueException;

final class Filter
{
    public readonly int $page;
    public readonly int $size;
    public readonly string $sort;
    public readonly string $order;

    public ?string $id = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $nickname = null;

    public function __construct(string $sort, string $order, int $page = 1, int $size = 10)
    {
        $this->page = $page;
        $this->size = $size;
        $this->sort = $sort;
        $this->order = $order;
    }

    public function getSort(): string
    {
        if (!in_array($this->sort, ['id', 'name', 'nickname', 'status'], true)) {
            throw new UnexpectedValueException('Cannot sort by '.$this->sort);
        }

        return $this->sort;
    }

    public function getOrder(): string
    {
        return 'desc' === $this->order ? 'desc' : 'asc';
    }
}
