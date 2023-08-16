<?php

declare(strict_types=1);

namespace BarCode\Render;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class Components implements IteratorAggregate
{
    /**
     * @var ComponentInterface[]
     */
    private array $components;

    public function addComponent(ComponentInterface $componentElement): void
    {
        $this->components[] = $componentElement;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->components);
    }
}