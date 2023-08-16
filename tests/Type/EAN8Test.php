<?php

declare(strict_types=1);

namespace Type;

use BarCode\{BarCode, Code};
use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\Type\EAN8;
use PHPUnit\Framework\TestCase;

class EAN8Test extends TestCase
{
    public function testGenerateBarCode_InsertTooShortCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new EAN8();
        $ean8->getBarCode(new Code('1234567'));
    }

    public function testGenerateBarCode_InsertTooLongCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new EAN8();
        $ean8->getBarCode(new Code('123456789'));
    }

    public function testGenerateBarCode_InsertAlphanumericalCode_ThrowException(): void
    {
        $this->expectException(InvalidCharacterException::class);

        $ean8 = new EAN8();
        $ean8->getBarCode(new Code('123A5670'));
    }

    public function testGenerateBarCode_GiveWrongCheckDigitCode_ThrowException(): void
    {
        $this->expectException(InvalidCheckDigitException::class);

        $ean8 = new EAN8();
        $ean8->getBarCode(new Code('12345671'));
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnBarCode(): void
    {
        $ean8 = new EAN8();
        $barCode = $ean8->getBarCode(new Code('12345670'));

        $this->assertInstanceOf(BarCode::class, $barCode);
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnValidCode(): void
    {
        $expectedBinaryCode = '1010011001001001101111010100011010101001110101000010001001110010101';

        $ean8 = new EAN8();
        $barCode = $ean8->getBarCode(new Code('12345670'));

        $binaryCode = implode(
            '',
            array_map(fn(bool $flag) => $flag ? '1' : '0',iterator_to_array($barCode->getBinary()))
        );

        $this->assertSame($expectedBinaryCode, $binaryCode);
    }
}