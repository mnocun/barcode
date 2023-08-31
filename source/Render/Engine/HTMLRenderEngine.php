<?php

declare(strict_types=1);

namespace BarCode\Render\Engine;

use BarCode\Render\{Component\Rectangle, Component\Text, Drawable, RenderEngineInterface, Workspace};

class HTMLRenderEngine implements RenderEngineInterface
{
    public function render(Workspace $workspace): string
    {
        return $this->renderContainer(
            $workspace, implode('', array_map(
                    fn(Drawable $component) => match (true) {
                        $component instanceof Rectangle => $this->renderRectangle($component),
                        $component instanceof Text => $this->renderText($component)
                    },
                    $workspace->getComponents()
                )
            )
        );
    }

    private function renderRectangle(Rectangle $component): string
    {
        $style = [
            'position' => 'absolute',
            'background' => "rgb({$component->getColor()})",
            'width' => "{$component->getWidth()}px",
            'height' => "{$component->getHeight()}px",
            'left' => "{$component->getStartPoint()->getHorizontal()}px",
            'top' => "{$component->getStartPoint()->getVertical()}px"
        ];

        return "<div style='{$this->generateStyle($style)}'></div>";
    }

    private function renderText(Text $component): string
    {
        $style = [
            'position' => 'absolute',
            'color' => "rgb({$component->getColor()})",
            'font-family' => $component->getFont()->getName(),
            'font-size' => "{$component->getFont()->getSize()}px",
            'left' => "{$component->getStartPoint()->getHorizontal()}px",
            'top' => "{$component->getStartPoint()->getVertical()}px"
        ];

        return "<div style='{$this->generateStyle($style)}'>{$component->getContent()}</div>";
    }

    private function renderContainer(Workspace $workspace, string $content): string
    {
        return "<div style='position:relative;margin:{$workspace->getMargin()}px'>{$content}</div>";
    }

    private function generateStyle(array $style): string
    {
        array_walk($style, fn(string &$item, string $key): string => "$key:$item");
        return implode(
                ';',
                array_map(fn(string $key, string $value) => "{$key}:{$value}", array_keys($style), $style)
            ) . ';';
    }
}