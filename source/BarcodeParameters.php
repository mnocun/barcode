<?php

declare(strict_types=1);

namespace BarCode;

class BarcodeParameters
{
    public function __construct(
        private float $width,
        private float $height
    )
    {
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