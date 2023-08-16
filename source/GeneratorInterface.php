<?php

declare(strict_types=1);

namespace BarCode;

interface GeneratorInterface
{
    public function generateBarCode(Code $code, TypeInterface $type, FormatInterface $format): string;
}