<?php

declare(strict_types=1);

namespace Type;

use BarCode\{Code, Barcode};
use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use PHPUnit\Framework\TestCase;
use BarCode\Type\UPCE;

class UPSETest extends TestCase
{
    public function testGenerateBarCode_InsertTooShortCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new UPCE();
        $ean8->getBarcode(new Code('0123456'));
    }

    public function testGenerateBarCode_InsertTooLongCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new UPCE();
        $ean8->getBarcode(new Code('0651000043'));
    }

    public function testGenerateBarCode_InsertAlphanumericalCode_ThrowException(): void
    {
        $this->expectException(InvalidCharacterException::class);

        $ean8 = new UPCE();
        $ean8->getBarcode(new Code('0123B567'));
    }

    public function testGenerateBarCode_GiveWrongCheckDigitCode_ThrowException(): void
    {
        $this->expectException(InvalidCheckDigitException::class);

        $ean8 = new UPCE();
        $ean8->getBarcode(new Code('01234567'));
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnBarCode(): void
    {
        $ean8 = new UPCE();
        $barcode = $ean8->getBarcode(new Code('02430096'));

        $this->assertInstanceOf(Barcode::class, $barcode);
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnValidCode(): void
    {
        $expectedBinaryCode = '101001101101000110111101000110101001110010111010101';

        $ean8 = new UPCE();
        $barcode = $ean8->getBarcode(new Code('02430096'));

        $binaryCode = implode(
            '',
            array_map(fn(bool $flag) => $flag ? '1' : '0', iterator_to_array($barcode))
        );

        $this->assertSame($expectedBinaryCode, $binaryCode);
    }
}