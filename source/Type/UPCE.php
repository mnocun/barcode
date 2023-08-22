<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\{Barcode, Code};

class UPCE extends UPC
{
    public const END_GUARD = [0, 1, 0, 1, 0, 1];
    public const PATTERN = [
        [1, 1, 1, 0, 0, 0], [1, 1, 0, 1, 0, 0],
        [1, 1, 0, 0, 1, 0], [1, 1, 0, 0, 0, 1],
        [1, 0, 1, 1, 0, 0], [1, 0, 0, 1, 1, 0],
        [1, 0, 0, 0, 1, 1], [1, 0, 1, 0, 1, 0],
        [1, 0, 1, 0, 0, 1], [1, 0, 0, 1, 0, 1],
    ];

    protected function getLength(): int
    {
        return 8;
    }

    /**
     * @throws InvalidCheckDigitException
     * @throws InvalidLengthException
     * @throws InvalidCharacterException
     */
    public function getBarcode(Code $code): Barcode
    {
        $this->validateCode($code);

        $barcode = new Barcode($code);
        $barcode->addSection(self::GUARD, self::HIGHLIGHTED_LINES);

        $pattern = self::PATTERN[(int)$code[7]];

        for ($i = 1; $i < 7; ++$i) {
            $barcode->addSection(self::START_ENCODED_DIGITS_GROUP[$pattern[$i - 1]][(int)$code[$i]]);
        }

        $barcode->addSection(self::END_GUARD, self::HIGHLIGHTED_LINES);
        return $barcode;
    }

    protected function calculateCheckDigit(Code $code): string
    {
        $stringCode = match ((int)$code[6]) {
            0, 1, 2 => $code[1] . $code[2] . $code[6] . '0000' . $code[3] . $code[4] . $code[5],
            3 => substr((string)$code, 1, 3) . '00000' . $code[4] . $code[5],
            4 => substr((string)$code, 1, 4) . '00000' . $code[5],
            default => substr((string)$code, 1, 5) . '0000' . $code[6]
        };

        return parent::calculateCheckDigit(new Code($stringCode));
    }
}