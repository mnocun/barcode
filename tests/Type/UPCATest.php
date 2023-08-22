<?php

declare(strict_types=1);

namespace Type;

use BarCode\{Code, Barcode};
use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use PHPUnit\Framework\TestCase;
use BarCode\Type\UPCA;

class UPCATest extends TestCase
{
    public function testGenerateBarCode_InsertTooShortCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new UPCA();
        $ean8->getBarcode(new Code('06510000432'));
    }

    public function testGenerateBarCode_InsertTooLongCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new UPCA();
        $ean8->getBarcode(new Code('0651000043273'));
    }

    public function testGenerateBarCode_InsertAlphanumericalCode_ThrowException(): void
    {
        $this->expectException(InvalidCharacterException::class);

        $ean8 = new UPCA();
        $ean8->getBarcode(new Code('065100004B27'));
    }

    public function testGenerateBarCode_GiveWrongCheckDigitCode_ThrowException(): void
    {
        $this->expectException(InvalidCheckDigitException::class);

        $ean8 = new UPCA();
        $ean8->getBarcode(new Code('065100004321'));
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnBarCode(): void
    {
        $ean8 = new UPCA();
        $barcode = $ean8->getBarcode(new Code('810012110099'));

        $this->assertInstanceOf(Barcode::class, $barcode);
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnValidCode(): void
    {
        $expectedBinaryCode = '10101011110001011001001101110110111011001100101010111010010010001100110110011010100001100110101';

        $ean8 = new UPCA();
        $barcode = $ean8->getBarcode(new Code('692771981161'));

        $binaryCode = implode(
            '',
            array_map(fn(bool $flag) => $flag ? '1' : '0', iterator_to_array($barcode))
        );

        $this->assertSame($expectedBinaryCode, $binaryCode);
    }
}