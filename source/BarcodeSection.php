<?php

declare(strict_types=1);

namespace BarCode;

class BarcodeSection
{
    public function __construct(
        private int   $width,
        private int   $position,
        private float $height
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