<?php

declare(strict_types=1);

namespace BarCode\Generator;

use BarCode\{Code, FormatInterface, GeneratorInterface, TypeInterface};

class HTML implements GeneratorInterface
{
    public function generateBarcode(Code $code, TypeInterface $type, FormatInterface $format): string
    {
        $barcode = $type->getBarcode($code);
        $components = $format->generateComponents($barcode);
        $response = '<div style="position: relative">';

        foreach ($components as $component) {
            $response .= "<div style=\"position:absolute;background:rgb({$component->getColor()});width:{$component->getWidth()}em;height:{$component->getHeight()}em;left:{$component->getHorizontalPosition()}em;top:{$component->getVerticalPosition()}em\"></div>";
        }

        $response .= '</div>';
        return $response;
    }
}