<?php

declare(strict_types=1);

namespace BarCode\Render;

interface ComponentInterface
{
    public function getColor(): Color;

    public function getWidth(): int;

    public function getHeight(): int;

    public function getVerticalPosition(): int;

    public function getHorizontalPosition(): int;
}