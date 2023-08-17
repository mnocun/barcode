<?php

declare(strict_types=1);

namespace BarCode;

class BarcodeSection
{
    public function __construct(
        private readonly int   $width,
        private readonly int   $position,
        private readonly float $height
    )
    {
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getHeight(): float
    {
        return $this->height;
    }
}