<?php

declare(strict_types=1);

namespace BarCode\Render;

abstract class Drawable
{
    public function __construct(protected Point $startPoint, protected Color $color)
    {
    }

    public function getStartPoint(): Point
    {
        return $this->startPoint;
    }

    public function getColor(): Color
    {
        return $this->color;
    }
}