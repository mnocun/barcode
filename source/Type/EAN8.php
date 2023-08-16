<?php

declare(strict_types=1);

namespace BarCode\Type;

class EAN8 extends EAN
{
    protected function getLength(): int
    {
        return 8;
    }
}