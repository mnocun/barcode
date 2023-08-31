<?php

declare(strict_types=1);

namespace BarCode\Format;

use BarCode\BarcodeSection;

class GuardFormat extends SimpleFormat
{
    protected function heightFactor(BarcodeSection $section): float
    {
        return $section->getHeight();
    }
}