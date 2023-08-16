<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\BarCode;
use BarCode\Code;
use BarCode\Exception\InvalidCharacterException;
use BarCode\Exception\InvalidCheckDigitException;
use BarCode\Exception\InvalidLengthException;
use BarCode\TypeInterface;

abstract class EAN implements TypeInterface
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
    public const PATTERN_RIGHT = [
        '0' => [1, 1, 1, 0, 1, 1, 0],
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
    public const START_GUARD = [1, 0, 1];
    public const MIDDLE_GUARD = [0, 1, 0, 1, 1];
    public const END_GUARD = [1, 0, 1];

    abstract protected function getLength(): int;

    /**
     * @throws InvalidLengthException
     * @throws InvalidCharacterException
     * @throws InvalidCheckDigitException
     */
    public function getBarCode(Code $code): BarCode
    {
        $this->validateCode($code);

        $barCode = new BarCode();
        $barCode->addSection(2, self::START_GUARD);
        $middlePosition = ceil($this->getLength() / 2);

        foreach ($code as $position => $character) {
            if ($position === $middlePosition) {
                $barCode->addSection(2, self::MIDDLE_GUARD);
            }

            $barCode->addSection(
                1,
                $position >= $middlePosition ? self::PATTERN_RIGHT[$character] : self::PATTERN_LEFT[$character]
            );
        }

        $barCode->addSection(2, self::END_GUARD);

        return $barCode;
    }

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