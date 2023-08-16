<?php

declare(strict_types=1);

namespace Type;

use BarCode\{BarCode, Code};
use BarCode\Exception\InvalidCharacterException;
use BarCode\Type\Standard2Of5;
use PHPUnit\Framework\TestCase;

class Standard2Of5Test extends TestCase
{
    public function testGenerateBarCode_InsertAlphanumericalCode_ThrowException(): void
    {
        $this->expectException(InvalidCharacterException::class);

        $ean8 = new Standard2Of5();
        $ean8->getBarCode(new Code('87654321A'));
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnBarCode(): void
    {
        $ean8 = new Standard2Of5();
        $barCode = $ean8->getBarCode(new Code('87654321'));

        $this->assertInstanceOf(BarCode::class, $barCode);
    }

    public function testGenerateBarCode_GiveCorrectCode_ReturnValidCode(): void
    {
        $expectedBinaryCode = '11011010111010101110101010101110111010111011101010111010111010101010111010111011101110101010101110101011101110101010111011010110';

        $ean8 = new Standard2Of5();
        $barCode = $ean8->getBarCode(new Code('87654321'));

        $binaryCode = implode(
            '',
            array_map(fn(bool $flag) => $flag ? '1' : '0', iterator_to_array($barCode->getBinary()))
        );

        $this->assertSame($expectedBinaryCode, $binaryCode);
    }
}