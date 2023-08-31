<?php

declare(strict_types=1);

namespace BarCode\Render\Font;

use BarCode\Render\FontInterface;

class Monospace implements FontInterface
{
    public function __construct(private int $size)
    {
    }

    public function getName(): string
    {
        return 'monospace';
    }

    public function getSize(): int
    {
        return $this->size;
    }
}