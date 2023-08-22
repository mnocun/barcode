<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\{Code, TypeInterface};
use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};

abstract class UPC implements TypeInterface
{
    public const HIGHLIGHTED_LINES = 1.1;
    public const GUARD = [1, 0, 1];
    public const MIDDLE_GUARD = [0, 1, 0, 1, 0];
    public const START_ENCODED_DIGITS_GROUP = [
        [
            [0, 0, 0, 1, 1, 0, 1], [0, 0, 1, 1, 0, 0, 1],
            [0, 0, 1, 0, 0, 1, 1], [0, 1, 1, 1, 1, 0, 1],
            [0, 1, 0, 0, 0, 1, 1], [0, 1, 1, 0, 0, 0, 1],
            [0, 1, 0, 1, 1, 1, 1], [0, 1, 1, 1, 0, 1, 1],
            [0, 1, 1, 0, 1, 1, 1], [0, 0, 0, 1, 0, 1, 1]
        ],
        [
            [0, 1, 0, 0, 1, 1, 1], [0, 1, 1, 0, 0, 1, 1],
            [0, 0, 1, 1, 0, 1, 1], [0, 1, 0, 0, 0, 0, 1],
            [0, 0, 1, 1, 1, 0, 1], [0, 1, 1, 1, 0, 0, 1],
            [0, 0, 0, 0, 1, 0, 1], [0, 0, 1, 0, 0, 0, 1],
            [0, 0, 0, 1, 0, 0, 1], [0, 0, 1, 0, 1, 1, 1]
        ]
    ];
    public const END_ENCODED_DIGITS = [
        [1, 1, 1, 0, 0, 1, 0],
        [1, 1, 0, 0, 1, 1, 0],
        [1, 1, 0, 1, 1, 0, 0],
        [1, 0, 0, 0, 0, 1, 0],
        [1, 0, 1, 1, 1, 0, 0],
        [1, 0, 0, 1, 1, 1, 0],
        [1, 0, 1, 0, 0, 0, 0],
        [1, 0, 0, 0, 1, 0, 0],
        [1, 0, 0, 1, 0, 0, 0],
        [1, 1, 1, 0, 1, 0, 0]
    ];


    abstract protected function getLength(): int;

    /**
     * @throws InvalidLengthException
     * @throws InvalidCheckDigitException
     * @throws InvalidCharacterException
     */
    protected function validateCode(Code $code): void
    {
        if ($code->length() !== $this->getLength()) {
            throw new InvalidLengthException();
        }

        if (!$code->isNumeric()) {
            throw new InvalidCharacterException();
        }

        if ($code[$code->length() - 1] !== $this->calculateCheckDigit($code)) {
            throw new InvalidCheckDigitException();
        }
    }

    protected function calculateCheckDigit(Code $code): string
    {
        $sum = array_sum(
            array_map(
                fn(int $position) => (int)($position % 2 ? $code[$position] * 3 : $code[$position]),
                array_keys($code->getArray())
            )
        );

        return (string)((10 - ($sum % 10)) % 10);
    }
}