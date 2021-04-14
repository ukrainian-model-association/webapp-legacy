<?php

namespace App\UI\Widget\CollageWidget;

class CollageHeader
{
    private $title;

    /** @var callable */
    private $extension;

    public static function create($title, $options = [])
    {
        return (new static())
            ->setTitle($title);
    }

    public function setTitle($text, $href = null)
    {
        $this->title = $text;

        if (null !== $href) {
            $this->title = [
                'href' => $href,
                'text' => $text,
            ];
        }

        return $this;
    }

    public function render()
    {
        return <<<HTML
<div class="small-title square_p">
    {$this->renderTitle()}
    {$this->renderExtension()}
</div>
HTML;
    }

    private function renderTitle()
    {
        $text = $this->title;

        if (true !== is_array($text)) {
            return $text;
        }

        $href = $text['href'];
        $text = $text['text'];

        return sprintf('<a href="%s">%s</a>', $href, $text);
    }

    /**
     * @return string|void
     */
    private function renderExtension()
    {
        if (!is_callable($this->extension)) {
            return;
        }

        return call_user_func($this->extension);
    }

    /**
     * @param callable $extension
     * @return CollageHeader
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }
}