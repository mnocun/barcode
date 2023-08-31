<?php

declare(strict_types=1);

namespace BarCode\Render;

class Workspace
{
    /**
     * @var Drawable[]
     */
    private array $components = [];

    public function __construct(
        private float $width,
        private float $height,
        private float $margin
    )
    {
    }

    public function attachComponent(Drawable $component): void
    {
        $this->components[] = $component;
    }

    /**
     * @return Drawable[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getMargin(): float
    {
        return $this->margin;
    }
}