<?php

declare(strict_types=1);

namespace BarCode\Render;

class Color
{
    public function __construct(private int $red, private int $green, private int $blue)
    {
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }

    public function getArray(): array
    {
        return [$this->red, $this->green, $this->blue];
    }

    public function __toString(): string
    {
        return $this->red . ', ' . $this->green . ', ' . $this->red;
    }
}