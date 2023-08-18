<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\{Code, TypeInterface};

abstract class EAN implements TypeInterface
{
    public const HIGHLIGHTED_LINES = 1.1;
    public const START_GUARD = [1, 0, 1];
    public const MIDDLE_GUARD = [0, 1, 0, 1, 0];
    public const END_GUARD = [1, 0, 1];

    public const PATTERN_RIGHT = [
        '0' => [1, 1, 1, 0, 0, 1, 0],
        '1' => [1, 1, 0, 0, 1, 1, 0],
        '2' => [1, 1, 0, 1, 1, 0, 0],
        '3' => [1, 0, 0, 0, 0, 1, 0],
        '4' => [1, 0, 1, 1, 1, 0, 0],
        '5' => [1, 0, 0, 1, 1, 1, 0],
        '6' => [1, 0, 1, 0, 0, 0, 0],
        '7' => [1, 0, 0, 0, 1, 0, 0],
        '8' => [1, 0, 0, 1, 0, 0, 0],
        '9' => [1, 1, 1, 0, 1, 0, 0]
    ];

    abstract protected function getLength(): int;

    /**
     * @throws InvalidCheckDigitException
     * @throws InvalidLengthException
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

        if ($this->calculateCheckDigit($code) !== $code[$this->getLength() - 1]) {
            throw new InvalidCheckDigitException();
        }
    }

    protected function calculateCheckDigit(Code $code): string
    {
        $sumEven = 0;
        $sumOdd = 0;

        foreach ($code as $character) {
            $character = (int)$character;

            if ($character % 2) {
                $sumEven += $character;
            } else {
                $sumOdd += $character;
            }
        }

        $totalSum = ($sumEven * 3) + $sumOdd;
        return (string)((10 - ($totalSum % 10)) % 10);
    }
}