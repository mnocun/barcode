<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\{Barcode, Code};

class Standard2Of5WithChecksum extends Standard2Of5
{
    public function getBarcode(Code $code): Barcode
    {
        $this->validateCode($code);

        $barcode = new Barcode($code);
        $barcode->addSection(self::START_SEQUENCE);

        foreach ($code as $character) {
            $barcode->addSection(self::PATTERN[(int)$character]);
        }

        $barcode->addSection(self::PATTERN[$this->calculateChecksum($code)]);
        $barcode->addSection(self::STOP_SEQUENCE);

        return $barcode;
    }

    private function calculateChecksum(Code $code): int
    {
        $sum = 0;

        for ($i = $code->length() - 1; $i >= 0; --$i) {
            $value = (int)$code[$i];
            $sum += $i % 2 === 0 ? $value : $value * 3;
        }

        return (10 - ($sum % 10)) % 10;
    }
}