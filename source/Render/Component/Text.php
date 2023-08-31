<?php

declare(strict_types=1);

namespace BarCode\Render\Component;

use BarCode\Render\{Color, Drawable, FontInterface, Point};

class Text extends Drawable
{
    public function __construct(
        Point                 $startPoint,
        private string        $content,
        private FontInterface $font,
        Color                 $color
    )
    {
        parent::__construct($startPoint, $color);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFont(): FontInterface
    {
        return $this->font;
    }
}