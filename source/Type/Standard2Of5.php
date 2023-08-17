<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\{Barcode, Code, Exception\InvalidCharacterException, TypeInterface};

class Standard2Of5 implements TypeInterface
{
    public const PATTERN = [
        [1, 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0],
        [1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 1, 1, 0],
        [1, 0, 1, 1, 1, 0, 1, 0, 1, 0, 1, 1, 1, 0],
        [1, 1, 1, 0, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0],
        [1, 0, 1, 0, 1, 1, 1, 0, 1, 0, 1, 1, 1, 0],
        [1, 1, 1, 0, 1, 0, 1, 1, 1, 0, 1, 0, 1, 0],
        [1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0, 1, 0],
        [1, 0, 1, 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0],
        [1, 1, 1, 0, 1, 0, 1, 0, 1, 1, 1, 0, 1, 0],
        [1, 0, 1, 1, 1, 0, 1, 0, 1, 1, 1, 0, 1, 0]
    ];
    public const START_SEQUENCE = [1, 1, 0, 1, 1, 0, 1, 0];
    public const STOP_SEQUENCE = [1, 1, 0, 1, 0, 1, 1, 0];

    /**
     * @throws InvalidCharacterException
     */
    public function getBarcode(Code $code): Barcode
    {
        $this->validateCode($code);

        $barcode = new Barcode($code);
        $barcode->addSection(self::START_SEQUENCE);

        foreach ($code as $character) {
            $barcode->addSection(self::PATTERN[(int)$character]);
        }

        $barcode->addSection(self::STOP_SEQUENCE);
        return $barcode;
    }

    /**
     * @throws InvalidCharacterException
     */
    protected function validateCode(Code $code): void
    {
        if (!$code->isNumeric()) {
            throw new InvalidCharacterException();
        }
    }
}