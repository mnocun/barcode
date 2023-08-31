<?php

declare(strict_types=1);

namespace BarCode\Render\Engine\Image;

use GdImage;
use BarCode\Render\Drawable;
use BarCode\Render\Component\{Rectangle, Text};
use BarCode\Render\Engine\RenderImageInterface;
use BarCode\Exception\UnsupportedExtensionException;

class GDImageRender implements RenderImageInterface
{
    private GdImage $resource;

    /**
     * @throws UnsupportedExtensionException
     */
    public function __construct(int $width, int $height, private string $imageFormat)
    {
        if (!extension_loaded('gd')) {
            throw new UnsupportedExtensionException();
        }

        $this->resource = imagecreate($width, $height);
    }

    public function renderRectangle(Rectangle $component): void
    {
        imagefilledrectangle(
            $this->resource,
            (int)$component->getStartPoint()->getHorizontal(),
            (int)$component->getStartPoint()->getVertical(),
            (int)($component->getStartPoint()->getHorizontal() + $component->getWidth()),
            (int)($component->getStartPoint()->getHorizontal() + $component->getHeight()),
            $this->getColor($component)
        );
    }

    public function renderText(Text $component): void
    {
        imagettftext(
            $this->resource,
            (float)$component->getFont()->getSize(),
            0.0,
            (int)$component->getStartPoint()->getHorizontal(),
            (int)$component->getStartPoint()->getVertical(),
            $this->getColor($component),
            $this->getFont($component),
            $component->getContent()
        );
    }

    public function render(): string
    {
        ob_start();

        match ($this->imageFormat) {
            'png' => imagepng($this->resource),
            'jpg', 'jpeg' => imagejpeg($this->resource),
            'gif' => imagegif($this->resource),
            'bmp' => imagebmp($this->resource),
            'webp' => imagewebp($this->resource)
        };

        return ob_get_clean();
    }

    private function getColor(Drawable $component): int
    {
        return imagecolorallocate($this->resource, ...$component->getColor()->getArray());
    }

    private function getFont(Text $component): string
    {
        return ''; // TODO: Create method to find font path
    }
}