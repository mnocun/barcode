<?php

declare(strict_types=1);

namespace BarCode\Generator;

use BarCode\{Code, FormatInterface, GeneratorInterface, TypeInterface};

class SVG implements GeneratorInterface
{
    public function generateBarcode(Code $code, TypeInterface $type, FormatInterface $format): string
    {
        $barcode = $type->getBarcode($code);
        $components = $format->generateComponents($barcode);
        $response = '<svg width="320" height="240" viewBox="0 0 240 320" fill="none" xmlns="http://www.w3.org/2000/svg">';

        foreach ($components as $component) {
            $response .= "<rect x=\"{$component->getHorizontalPosition()}\" y=\"{$component->getVerticalPosition()}\" width=\"{$component->getWidth()}\" height=\"{$component->getHeight()}\" style=\"fill:rgb({$component->getColor()})\"  />";
        }

        $response .= '</svg>';
        return $response;
    }
}