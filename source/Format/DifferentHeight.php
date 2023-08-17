<?php

declare(strict_types=1);

namespace BarCode\Format;

use BarCode\{Barcode, FormatInterface};
use BarCode\Render\{Color, Components, Component\Rectangle};

class DifferentHeight implements FormatInterface
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
                    (int)(50 * $section->getHeight()),
                    new Color(0, 0, 0)
                )
            );
        }

        return $components;
    }
}