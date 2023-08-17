<?php

declare(strict_types=1);

namespace BarCode\Format;

use BarCode\{Barcode,FormatInterface};
use BarCode\Render\Components;

class WithCode implements FormatInterface
{
    public function generateComponents(Barcode $barcode): Components
    {
        return new Components();
    }
}