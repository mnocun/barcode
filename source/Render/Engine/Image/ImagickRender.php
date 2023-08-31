<?php

declare(strict_types=1);

namespace BarCode\Render\Engine\Image;

use BarCode\Exception\UnsupportedExtensionException;
use BarCode\Render\Component\{Rectangle, Text};
use BarCode\Render\Engine\RenderImageInterface;
use Imagick, ImagickDraw, ImagickPixel, ImagickException, ImagickDrawException;

class ImagickRender implements RenderImageInterface
{
    private Imagick $resource;
    private ImagickDraw $drawResource;

    /**
     * @throws UnsupportedExtensionException
     * @throws ImagickException
     */
    public function __construct(int $width, int $height, string $imageFormat)
    {
        if (!extension_loaded('imagick')) {
            throw new UnsupportedExtensionException();
        }

        $this->resource = new Imagick();
        $this->resource->newImage($width, $height, new ImagickPixel(), $imageFormat);
        $this->drawResource = new ImagickDraw();
    }

    /**
     * @throws ImagickDrawException
     */
    public function renderRectangle(Rectangle $component): void
    {
        $this->drawResource->setFillColor(new ImagickPixel("rgb({$component->getColor()})"));
        $this->drawResource->rectangle(
            $component->getStartPoint()->getHorizontal(),
            $component->getStartPoint()->getVertical(),
            $component->getStartPoint()->getHorizontal() + $component->getWidth(),
            $component->getStartPoint()->getHorizontal() + $component->getHeight()
        );
    }

    /**
     * @throws ImagickException
     * @throws ImagickDrawException
     */
    public function renderText(Text $component): void
    {
        $this->drawResource->setFont($component->getFont()->getName());
        $this->drawResource->setFontSize($component->getFont()->getSize());
        $this->drawResource->setFillColor(new ImagickPixel("rgb({$component->getColor()})"));
        $this->drawResource->annotation(
            $component->getStartPoint()->getHorizontal(),
            $component->getStartPoint()->getVertical(),
            $component->getContent()
        );
    }

    /**
     * @throws ImagickException
     */
    public function render(): string
    {
        $this->resource->drawImage($this->drawResource);
        return $this->resource->getImageBlob();
    }
}