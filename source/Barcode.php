<?php

declare(strict_types=1);

namespace BarCode;

use ArrayIterator;
use CallbackFilterIterator;
use Generator;
use IteratorAggregate;

class Barcode implements IteratorAggregate
{
    private array $binarySequence = [];
    private array $heightMap = [];

    public function __construct(private readonly Code $code)
    {
    }

    public function addSection(array $section, float $height = 1.0): void
    {
        $this->binarySequence = [...$this->binarySequence, ...$section];
        $this->heightMap = [...$this->heightMap, ...array_fill(0, count($section), $height)];
    }

    /**
     * @return Generator<BarcodeSection>
     */
    public function getSections(): Generator
    {
        $binarySequenceIterator = new CallbackFilterIterator($this->getIterator(), fn(bool $value) => $value);

        $sequencePosition = null;
        $sectionPosition = null;
        $sectionHeight = 1.0;
        $sectionWidth = 1;

        foreach ($binarySequenceIterator as $position => $value) {
            if ($sectionPosition === null) {
                $sectionPosition = $position;
                $sequencePosition = $position;
                $sectionHeight = $this->heightMap[$position];
            } elseif ($position === $sectionPosition + 1 && $sectionHeight === $this->heightMap[$position + 1]) {
                ++$sectionWidth;
                ++$sectionPosition;
            } else {
                yield new BarcodeSection($sectionWidth, $sequencePosition, $sectionHeight);
                $sectionHeight = $this->heightMap[$position];
                $sequencePosition = $position;
                $sectionPosition = $position;
                $sectionWidth = 1;
            }
        }

        yield new BarcodeSection($sectionWidth, $sequencePosition, $sectionHeight);
    }

    public function getCode(): Code
    {
        return $this->code;
    }

    /**
     * @return ArrayIterator<int, bool>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->binarySequence);
    }
}