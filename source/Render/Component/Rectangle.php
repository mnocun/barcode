<?php

declare(strict_types=1);

namespace BarCode\Render\Component;

use BarCode\Render\{Color, ComponentInterface};

class Rectangle implements ComponentInterface
{
    public function __construct(
        private float $x,
        private float $y,
        private float $width,
        private float $height,
        private Color $color
    ) {}

    public function getColor(): Color
    {
        return $this->color;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getVerticalPosition(): float
    {
        return $this->y;
    }

    public function getHorizontalPosition(): float
    {
        return $this->x;
    }
}