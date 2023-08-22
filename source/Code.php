<?php

declare(strict_types=1);

namespace BarCode;

use ArrayAccess;
use ArrayIterator;
use BarCode\Exception\ReadOnlyException;
use IteratorAggregate;
use Traversable;

class Code implements IteratorAggregate, ArrayAccess
{
    public function __construct(private string $code)
    {
    }

    public function isNumeric(): bool
    {
        return (bool)preg_match('/^[0-9]+$/', $this->code);
    }

    public function length(): int
    {
        return strlen($this->code);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->getArray());
    }

    /**
     * @return string[]
     */
    public function getArray(): array
    {
        return str_split($this->code);
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

    /**
     * @throws ReadOnlyException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new ReadOnlyException();
    }

    /**
     * @throws ReadOnlyException
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new ReadOnlyException();
    }
}