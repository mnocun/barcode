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
            $response .= "<div style=\"position:absolute;background:rgb({$component->getColor()});width:{$component->getWidth()}px;height:{$component->getHeight()}px;left:{$component->getHorizontalPosition()}px;top:{$component->getVerticalPosition()}px\"></div>";
        }

        $response .= '</div>';
        return $response;
    }
}