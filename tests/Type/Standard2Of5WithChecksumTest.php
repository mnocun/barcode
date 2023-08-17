<?php

declare(strict_types=1);

namespace Type;

use BarCode\{Barcode, Code};
use BarCode\Exception\InvalidCharacterException;
use BarCode\Type\Standard2Of5WithChecksum;
use PHPUnit\Framework\TestCase;

class Standard2Of5WithChecksumTest extends TestCase
{
    public function testGenerateBarCode_InsertAlphanumericalCode_ThrowException(): void
    {
        $this->expectException(InvalidCharacterException::class);

        $ean8 = new Standard2Of5WithChecksum();
        $ean8->getBarcode(new Code('87654321A'));
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnBarCode(): void
    {
        $ean8 = new Standard2Of5WithChecksum();
        $barCode = $ean8->getBarcode(new Code('87654321'));

        $this->assertInstanceOf(Barcode::class, $barCode);
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnValidCode(): void
    {
        $expectedBinaryCode = '1101101011101010111010101010111011101011101110101011101011101010101011101011101110111010101010111010101110111010101011101011101010111011010110';

        $ean8 = new Standard2Of5WithChecksum();
        $barCode = $ean8->getBarcode(new Code('87654321'));

        $binaryCode = implode(
            '',
            array_map(fn(bool $flag) => $flag ? '1' : '0', iterator_to_array($barCode))
        );

        $this->assertSame($expectedBinaryCode, $binaryCode);
    }
}