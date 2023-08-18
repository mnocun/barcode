<?php

declare(strict_types=1);

use BarCode\{Barcode, BarcodeSection, Code};
use PHPUnit\Framework\TestCase;

class BarcodeTest extends TestCase
{
    public function testBarcode_GiveSectionsAndCompareBinary_ReturnValidBinaryCode(): void
    {
        $barcode = new Barcode(new Code(''));

        $expectedBinaryRepresentation = [1, 0, 0, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1, 1];

        $barcode->addSection([1, 0, 0, 1, 1, 1, 1, 0, 1]);
        $barcode->addSection([0, 1, 0, 1, 0, 0, 0, 1, 1]);

        $this->assertSame($expectedBinaryRepresentation, iterator_to_array($barcode->getIterator()));
    }

    public function testBarcode_GiveSectionsAndCompareBySection_ReturnValidSections(): void
    {
        $barcode = new Barcode(new Code(''));
        $barcode->addSection([
            1, 0, 1, 0, 0, 1, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 1, 1, 0, 1, 0,
            1, 0, 1, 0, 0, 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1
        ]);

        $expectedSections = [
            [1, 0],
            [1, 2],
            [2, 5],
            [1, 9],
            [1, 12],
            [2, 15],
            [4, 18],
            [1, 23],
            [1, 25],
            [2, 29],
            [1, 32],
            [1, 34],
            [1, 36],
            [3, 39],
            [1, 43],
            [1, 45],
            [1, 50],
            [1, 54],
            [3, 57],
            [1, 62],
            [1, 64],
            [1, 66]
        ];

        $this->assertSame(
            $expectedSections,
            array_map(
                fn(BarcodeSection $section) => [$section->getWidth(), $section->getPosition()],
                iterator_to_array($barcode->getSections())
            )
        );
    }
}