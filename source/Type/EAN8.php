<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\{Code, Barcode};

class EAN8 extends UPC
{
    public const START_ENCODED_DIGITS = [
        [0, 0, 0, 1, 0, 0, 1],
        [0, 0, 1, 1, 0, 0, 1],
        [0, 0, 1, 0, 0, 1, 1],
        [0, 1, 1, 1, 1, 0, 1],
        [0, 1, 0, 0, 0, 1, 1],
        [0, 1, 1, 0, 0, 0, 1],
        [0, 1, 0, 1, 1, 1, 1],
        [0, 1, 1, 1, 0, 1, 1],
        [0, 1, 1, 0, 1, 1, 1],
        [0, 0, 0, 1, 0, 1, 1]
    ];

    protected function getLength(): int
    {
        return 8;
    }

    /**
     * @throws InvalidLengthException
     * @throws InvalidCharacterException
     * @throws InvalidCheckDigitException
     */
    public function getBarcode(Code $code): Barcode
    {
        $this->validateCode($code);

        $barCode = new Barcode($code);
        $barCode->addSection(self::GUARD, self::HIGHLIGHTED_LINES);

        for ($i = 0; $i < 4; ++$i) {
            $barCode->addSection(self::START_ENCODED_DIGITS[(int)$code[$i]]);
        }

        $barCode->addSection(self::MIDDLE_GUARD, self::HIGHLIGHTED_LINES);

        for (; $i < 8; ++$i) {
            $barCode->addSection(self::END_ENCODED_DIGITS[(int)$code[$i]]);
        }

        $barCode->addSection(self::GUARD, self::HIGHLIGHTED_LINES);

        return $barCode;
    }

    protected function calculateCheckDigit(Code $code): string
    {
        $sum = array_sum(
            array_map(
                fn(int $position) => (int)($position % 2 ? $code[$position] : $code[$position] * 3),
                array_keys($code->getArray())
            )
        );

        return (string)((10 - ($sum % 10)) % 10);
    }
}