<?php

declare(strict_types=1);

namespace BarCode\Render;

interface FontInterface
{
    public function getName(): string;

    public function getSize(): int;
}