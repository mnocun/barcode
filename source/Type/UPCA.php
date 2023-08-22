<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\{Barcode, Code};

class UPCA extends UPC
{
    protected function getLength(): int
    {
        return 12;
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
        $barcode->addSection(self::START_ENCODED_DIGITS_GROUP[0][$code[0]]);

        for ($i = 1; $i < 6; ++$i) {
            $barcode->addSection(self::START_ENCODED_DIGITS_GROUP[0][$code[$i]]);
        }

        $barcode->addSection(self::MIDDLE_GUARD, self::HIGHLIGHTED_LINES);

        for (; $i < 11; ++$i) {
            $barcode->addSection(self::END_ENCODED_DIGITS[$code[$i]]);
        }

        $barcode->addSection(self::END_ENCODED_DIGITS[$code[11]]);
        $barcode->addSection(self::GUARD, self::HIGHLIGHTED_LINES);
        return $barcode;
    }

    public function calculateCheckDigit(Code $code): string
    {
        return parent::calculateCheckDigit(
            new Code(substr((string)$code, 0, $code->length() - 1))
        );
    }
}