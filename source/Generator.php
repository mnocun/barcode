<?php

declare(strict_types=1);

namespace BarCode;

use BarCode\Render\RenderEngineInterface;

class Generator
{
    public static function generate(
        Barcode               $barcode,
        FormatInterface       $format,
        RenderEngineInterface $renderEngine
    ): string
    {
        $workspace = $format->createWorkspace($barcode);
        return $renderEngine->render($workspace);
    }
}