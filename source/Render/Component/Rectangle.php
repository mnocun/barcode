<?php

declare(strict_types=1);

namespace BarCode\Render\Component;

use BarCode\Render\{Color, Drawable, Point};

class Rectangle extends Drawable
{
    public function __construct(
        Point         $startPoint,
        private float $width,
        private float $height,
        Color         $color
    )
    {
        parent::__construct($startPoint, $color);
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }
}