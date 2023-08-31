<?php

declare(strict_types=1);

namespace BarCode\Render;

interface RenderEngineInterface
{
    public function render(Workspace $workspace): string;
}