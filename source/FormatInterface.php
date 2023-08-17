<?php

declare(strict_types=1);

namespace BarCode;

use BarCode\Render\Components;

interface FormatInterface
{
    public function generateComponents(Barcode $barcode): Components;
}