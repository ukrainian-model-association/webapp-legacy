<?php


namespace App\Bootstrap\Components;


class Card
{
    /** @var array */
    private $header;

    /** @var array */
    private $body;

    /** @var array */
    private $footer;

    public function __construct()
    {
        $this->header = [];
        $this->body   = [];
        $this->footer = [];
    }

    public static function create()
    {
        return new self();
    }

    public function __toString()
    {
        $children = [];

        foreach (['header', 'body', 'footer'] as $div) {
            if (!(count($this->{$div}) > 0)) {
                continue;
            }

            $children[] = sprintf('<div class="card-%s">%s</div>', $div, implode(PHP_EOL, $this->{$div}));
        }

        return sprintf('<div class="card">%s</div>', implode(PHP_EOL, $children));
    }
}
