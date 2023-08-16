<?php

declare(strict_types=1);

namespace BarCode;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

class Code implements IteratorAggregate, ArrayAccess
{
    public function __construct(private readonly string $code)
    {
    }

    public function isNumeric(): bool
    {
        return is_numeric($this->code);
    }

    public function length(): int
    {
        return strlen($this->code);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator(str_split($this->code));
    }

    public function __toString(): string
    {
        return $this->code;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->code[(int)$offset]);
    }

    public function offsetGet(mixed $offset): string
    {
        return $this->code[(int)$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
    }

    public function offsetUnset(mixed $offset): void
    {
    }
}