<?php

declare(strict_types=1);

namespace BarCode\Format;

use BarCode\{Barcode,
    BarcodeSection,
    Render\Color,
    Render\Component\Text,
    Render\Font\Monospace,
    Render\Point
};
use BarCode\Render\Workspace;

class SimpleWithCodeFormat extends SimpleFormat
{
    private const HEIGHT_FACTOR = 0.8;

    public function createWorkspace(Barcode $barcode): Workspace
    {
        $workspace = parent::createWorkspace($barcode);
        $workspace->attachComponent(new Text(
            new Point($workspace->getHeight() * self::HEIGHT_FACTOR, 0),
            (string)$barcode->getCode(),
            new Monospace(12),
            new Color(0, 0, 0)
        ));

        return $workspace;
    }

    protected function heightFactor(BarcodeSection $section): float
    {
        return self::HEIGHT_FACTOR;
    }
}