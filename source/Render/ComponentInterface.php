<?php

declare(strict_types=1);

namespace BarCode\Render;

interface ComponentInterface
{
    public function getColor(): Color;

    public function getWidth(): float;

    public function getHeight(): float;

    public function getVerticalPosition(): float;

    public function getHorizontalPosition(): float;
}