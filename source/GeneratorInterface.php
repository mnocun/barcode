<?php

declare(strict_types=1);

namespace BarCode;

interface GeneratorInterface
{
    public function generateBarcode(Code $code, TypeInterface $type, FormatInterface $format): string;
}