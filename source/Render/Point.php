<?php

declare(strict_types=1);

namespace BarCode\Render;

final class Point
{
    public function __construct(private float $vertical, private float $horizontal)
    {
    }

    public function getVertical(): float
    {
        return $this->vertical;
    }

    public function getHorizontal(): float
    {
        return $this->horizontal;
    }
}