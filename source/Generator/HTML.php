<?php

declare(strict_types=1);

namespace BarCode\Generator;

use BarCode\{Code, FormatInterface, GeneratorInterface, TypeInterface};

class HTML implements GeneratorInterface
{
    public function generateBarCode(Code $code, TypeInterface $type, FormatInterface $format): string
    {
        return '';
    }
}