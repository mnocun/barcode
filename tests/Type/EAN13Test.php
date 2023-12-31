<?php

declare(strict_types=1);

namespace Type;

use BarCode\{Barcode, Code};
use BarCode\Exception\{InvalidCharacterException, InvalidCheckDigitException, InvalidLengthException};
use BarCode\Type\EAN13;
use PHPUnit\Framework\TestCase;

class EAN13Test extends TestCase
{
    public function testGenerateBarCode_InsertTooShortCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new EAN13();
        $ean8->getBarcode(new Code('123456789012'));
    }

    public function testGenerateBarCode_InsertTooLongCode_ThrowException(): void
    {
        $this->expectException(InvalidLengthException::class);

        $ean8 = new EAN13();
        $ean8->getBarcode(new Code('12345678901234'));
    }

    public function testGenerateBarCode_InsertAlphanumericalCode_ThrowException(): void
    {
        $this->expectException(InvalidCharacterException::class);

        $ean8 = new EAN13();
        $ean8->getBarcode(new Code('2109B76543210'));
    }

    public function testGenerateBarCode_GiveWrongCheckDigitCode_ThrowException(): void
    {
        $this->expectException(InvalidCheckDigitException::class);

        $ean8 = new EAN13();
        $ean8->getBarcode(new Code('1234567890123'));
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnBarCode(): void
    {
        $ean8 = new EAN13();
        $barcode = $ean8->getBarcode(new Code('2109876543210'));

        $this->assertInstanceOf(Barcode::class, $barcode);
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnValidCode(): void
    {
        $expectedBinaryCode = '10100110010001101001011100010010111011000010101010100111010111001000010110110011001101110010101';

        $ean8 = new EAN13();
        $barcode = $ean8->getBarcode(new Code('2109876543210'));

        $binaryCode = implode(
            '',
            array_map(fn(bool $flag) => $flag ? '1' : '0', iterator_to_array($barcode))
        );

        $this->assertSame($expectedBinaryCode, $binaryCode);
    }
}