<?php

declare(strict_types=1);

namespace BarCode\Render\Component;

use BarCode\Render\{Color, ComponentInterface};

class Rectangle implements ComponentInterface
{
    public function __construct(
        private int $x,
        private int $y,
        private int $width,
        private int $height,
        private Color $color
    ) {}

    public function getColor(): Color
    {
        return $this->color;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getVerticalPosition(): int
    {
        return $this->y;
    }

    public function getHorizontalPosition(): int
    {
        return $this->x;
    }
}