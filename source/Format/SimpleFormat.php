<?php

declare(strict_types=1);

namespace BarCode\Format;

use BarCode\{Barcode, BarcodeSection, FormatInterface};
use BarCode\Render\{Color, Component\Rectangle, Point, Workspace};

class SimpleFormat implements FormatInterface
{
    public function __construct(private Workspace $workspace)
    {
    }

    public function createWorkspace(Barcode $barcode): Workspace
    {
        $singleSectionWidth = $this->workspace->getWidth() / $barcode->getBinaryLength();
        $normalizedHeight = $this->workspace->getHeight() / $barcode->getMaxHeightFactor();

        foreach ($barcode->getSections() as $section) {
            $this->workspace->attachComponent(
                new Rectangle(
                    new Point(0.0, $section->getPosition() * $singleSectionWidth),
                    $section->getWidth() * $singleSectionWidth,
                    $normalizedHeight * $this->heightFactor($section),
                    new Color(0, 0, 0)
                )
            );
        }

        return $this->workspace;
    }

    protected function heightFactor(BarcodeSection $section): float
    {
        return 1.0;
    }
}