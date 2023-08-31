<?php

declare(strict_types=1);

namespace BarCode;

use BarCode\Render\Workspace;

interface FormatInterface
{
    public function createWorkspace(Barcode $barcode): Workspace;
}