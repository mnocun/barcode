<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\{Code, Barcode};

class EAN13 extends UPC
{
    public const PATTERN = [
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 1, 0, 1, 1],
        [0, 0, 0, 1, 1, 0, 1],
        [0, 0, 0, 1, 1, 1, 0],
        [0, 0, 1, 0, 0, 1, 1],
        [0, 0, 1, 1, 0, 0, 1],
        [0, 0, 1, 1, 1, 0, 0],
        [0, 0, 1, 0, 1, 0, 1],
        [0, 0, 1, 0, 1, 1, 0],
        [0, 0, 1, 1, 0, 1, 0]
    ];

    protected function getLength(): int
    {
        return 13;
    }

    /**
     * @throws InvalidLengthException
     * @throws InvalidCharacterException
     * @throws InvalidCheckDigitException
     */
    public function getBarcode(Code $code): Barcode
    {
        $this->validateCode($code);

        $firstDigit = (int)$code[0];

        $barCode = new Barcode($code);
        $barCode->addSection(self::GUARD, self::HIGHLIGHTED_LINES);

        for ($i = 1; $i < 7; ++$i) {
            $barCode->addSection(self::START_ENCODED_DIGITS_GROUP[self::PATTERN[$firstDigit][$i]][(int)$code[$i]]);
        }

        $barCode->addSection(self::MIDDLE_GUARD, self::HIGHLIGHTED_LINES);

        for (; $i < 13; ++$i) {
            $barCode->addSection(self::END_ENCODED_DIGITS[(int)$code[$i]]);
        }

        $barCode->addSection(self::GUARD, self::HIGHLIGHTED_LINES);

        return $barCode;
    }
}