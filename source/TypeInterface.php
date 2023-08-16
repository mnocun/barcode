<?php

declare(strict_types=1);

namespace BarCode;

interface TypeInterface
{
    public function getBarCode(Code $code): BarCode;
}