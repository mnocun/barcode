<?php

declare(strict_types=1);

namespace BarCode\Type;

use BarCode\BarCode;
use BarCode\Code;
use BarCode\Exception\InvalidCharacterException;
use BarCode\Exception\InvalidCheckDigitException;
use BarCode\Exception\InvalidLengthException;

class EAN13 extends EAN
{
    public const PATTERN_FIRST_DIGITS = [
        '0' => [0, 0, 0, 0, 0, 0, 0],
        '1' => [0, 0, 0, 1, 0, 1, 1],
        '2' => [0, 0, 0, 1, 1, 0, 1],
        '3' => [0, 0, 0, 1, 1, 1, 0],
        '4' => [0, 0, 1, 0, 0, 1, 1],
        '5' => [0, 0, 1, 1, 0, 0, 1],
        '6' => [0, 0, 1, 1, 1, 0, 0],
        '7' => [0, 0, 1, 0, 1, 0, 1],
        '8' => [0, 0, 1, 0, 1, 1, 0],
        '9' => [0, 0, 1, 1, 0, 1, 0]
    ];
    public const PATTERN_LEFT = [
        0 => [
            '0' => [0, 0, 0, 1, 1, 0, 1],
            '1' => [0, 0, 1, 1, 0, 0, 1],
            '2' => [0, 0, 1, 0, 0, 1, 1],
            '3' => [0, 1, 1, 1, 1, 0, 1],
            '4' => [0, 1, 0, 0, 0, 1, 1],
            '5' => [0, 1, 1, 0, 0, 0, 1],
            '6' => [0, 1, 0, 1, 1, 1, 1],
            '7' => [0, 1, 1, 1, 0, 1, 1],
            '8' => [0, 1, 1, 0, 1, 1, 1],
            '9' => [0, 0, 0, 1, 0, 1, 1]
        ],
        1 => [
            '0' => [0, 1, 0, 0, 1, 1, 1],
            '1' => [0, 1, 1, 0, 0, 1, 1],
            '2' => [0, 0, 1, 1, 0, 1, 1],
            '3' => [0, 1, 0, 0, 0, 0, 1],
            '4' => [0, 0, 1, 1, 1, 0, 1],
            '5' => [0, 1, 1, 1, 0, 0, 1],
            '6' => [0, 0, 0, 0, 1, 0, 1],
            '7' => [0, 0, 1, 0, 0, 0, 1],
            '8' => [0, 0, 0, 1, 0, 0, 1],
            '9' => [0, 0, 1, 0, 1, 1, 1]]
    ];
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

    public const MIDDLE_GUARD = [0, 1, 0, 1, 0];

    protected function getLength(): int
    {
        return 13;
    }

    /**
     * @throws InvalidLengthException
     * @throws InvalidCharacterException
     * @throws InvalidCheckDigitException
     */
    public function getBarCode(Code $code): BarCode
    {
        $this->validateCode($code);

        $firstDigit = $code[0];

        $barCode = new BarCode();
        $barCode->addSection(2, self::START_GUARD);

        for ($i = 1; $i < 7; ++$i) {
            $barCode->addSection(1, self::PATTERN_LEFT[self::PATTERN_FIRST_DIGITS[$firstDigit][$i]][$code[$i]]);
        }

        $barCode->addSection(2, self::MIDDLE_GUARD);

        for (; $i < 13; ++$i) {
            $barCode->addSection(1, self::PATTERN_RIGHT[$code[$i]]);
        }

        $barCode->addSection(2, self::END_GUARD);

        return $barCode;
    }
}