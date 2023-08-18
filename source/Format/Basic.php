<?php

declare(strict_types=1);

namespace BarCode\Format;

use BarCode\{Barcode, BarcodeSection, FormatInterface};
use BarCode\Render\{Color, Components, Component\Rectangle};

class Basic implements FormatInterface
{
    public function generateComponents(Barcode $barcode): Components
    {
        $components = new Components();

        foreach ($barcode->getSections() as $section) {
            $components->addComponent(
                new Rectangle(
                    $section->getPosition(),
                    0,
                    $section->getWidth(),
                    (int)(50 * $this->heightFactor($section)),
                    new Color(0, 0, 0)
                )
            );
        }

        return $components;
    }

    protected function heightFactor(BarcodeSection $section): float
    {
        return 1.0;
    }
}