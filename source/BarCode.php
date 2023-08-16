<?php

declare(strict_types=1);

namespace BarCode;

use Generator;

class BarCode
{
    /**
     * @var array[] $sections
     */
    public function __construct(private array $sections = [])
    {
    }

    public function addSection(int $height, array $section): void
    {
        $this->sections[] = [$height, $section];
    }

    /**
     * @return Generator<int, array>
     */
    public function getSections(): Generator
    {
        foreach ($this->sections as [$height, $section]) {
            yield [$height, $section];
        }
    }

    /**
     * @return Generator<bool>
     */
    public function getBinary(): Generator
    {
        foreach ($this->sections as [, $section]) {
            foreach ($section as $flag) {
                yield $flag;
            }
        }
    }
}