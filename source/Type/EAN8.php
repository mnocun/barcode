<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\{Code, Barcode};

class EAN8 extends EAN
{
    public const PATTERN_LEFT = [
        '0' => [0, 0, 0, 1, 0, 0, 1],
        '1' => [0, 0, 1, 1, 0, 0, 1],
        '2' => [0, 0, 1, 0, 0, 1, 1],
        '3' => [0, 1, 1, 1, 1, 0, 1],
        '4' => [0, 1, 0, 0, 0, 1, 1],
        '5' => [0, 1, 1, 0, 0, 0, 1],
        '6' => [0, 1, 0, 1, 1, 1, 1],
        '7' => [0, 1, 1, 1, 0, 1, 1],
        '8' => [0, 1, 1, 0, 1, 1, 1],
        '9' => [0, 0, 0, 1, 0, 1, 1]
    ];

    /**
     * @throws InvalidLengthException
     * @throws InvalidCharacterException
     * @throws InvalidCheckDigitException
     */
    public function getBarcode(Code $code): Barcode
    {
        $this->validateCode($code);

        $barCode = new Barcode($code);
        $barCode->addSection(self::START_GUARD, 1.2);

        for ($i = 0; $i < 4; ++$i) {
            $barCode->addSection(self::PATTERN_LEFT[$code[$i]]);
        }

        $barCode->addSection(self::MIDDLE_GUARD, 1.2);

        for (; $i < 8; ++$i) {
            $barCode->addSection(self::PATTERN_RIGHT[$code[$i]]);
        }

        $barCode->addSection(self::END_GUARD, 1.2);

        return $barCode;
    }

    protected function getLength(): int
    {
        return 8;
    }
}