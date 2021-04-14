<?php

namespace App\Component\UI;

class Avatar
{
    private $imgSrc = '/no_image.png';
    private $alt;
    private $style;

    public function __construct($profile)
    {
        $this->alt   = sprintf('%s %s', $profile['first_name'], $profile['last_name']);
        $this->style = [];
        $this->handleProfile($profile);
    }

    /**
     * @param array $profile
     *
     * @return Avatar
     */
    public static function create($profile)
    {
        return new self($profile);
    }

    /**
     * @param array $style
     *
     * @return self
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    public function __toString()
    {
        $style = '';
        if (count($this->style) > 0) {
            $style = sprintf(' style="%s"', implode('; ', array_map(function ($key, $value) {
                return sprintf('%s: %s', $key, $value);
            }, array_keys($this->style), array_values($this->style))));
        }

        return sprintf('<img src="%s" alt="%s"%s/>', $this->imgSrc, $this->alt, $style);
    }

    private function handleProfile($profile)
    {
        if ($profile['pid'] > 0) {
            $crop         = unserialize($profile['ph_crop']);
            $this->imgSrc = vsprintf('/imgserve?pid=%s&x=%s&y=%s&w=%s&h=%s&z=%s', [
                $profile['pid'],
                $crop['x'],
                $crop['y'],
                !$crop['w'] ? 165 : $crop['w'],
                !$crop['h'] ? 165 : $crop['h'],
                'crop',
            ]);
        }
    }
}


