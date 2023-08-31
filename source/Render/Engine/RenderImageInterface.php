<?php

declare(strict_types=1);

namespace BarCode\Render\Engine;

use BarCode\Render\Component\{Rectangle, Text};

interface RenderImageInterface
{
    public function __construct(int $width, int $height, string $imageFormat);

    public function renderRectangle(Rectangle $component): void;

    public function renderText(Text $component): void;

    public function render(): string;
}