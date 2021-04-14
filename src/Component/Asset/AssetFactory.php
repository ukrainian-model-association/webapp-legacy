<?php

namespace App\Component\Asset;

use App\Common\Utils\StringUtils;
use conf;

class AssetFactory
{
    const SCRIPT_URL_TEMPLATE     = 'https://js.%s/%s';
    const STYLESHEET_URL_TEMPLATE = 'https://css.%s/%s';

    /** @var AssetFactory */
    private static $instance;

    /**
     * @return AssetFactory
     */
    public static function create()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $src
     * @param array $attrs
     * @return string
     */
    public function script($src, $attrs = [])
    {
        $src   = $this->sanitizeUrl($src, self::SCRIPT_URL_TEMPLATE);
        $attrs = array_merge(['type' => 'text/javascript', 'src' => $src], $attrs);

        return $this->render(sprintf('<script %s></script>', $this->stringifyAttrs($attrs)));
    }

    public function sanitizeUrl($url, $urlTemplate = null)
    {
        if ($urlTemplate !== null && !preg_match('/^https?:\/\/.+$/', $url)) {
            $url = sprintf($urlTemplate, conf::get('server'), ltrim($url, '/'));
        }

        return $url;
    }

    private function render($content)
    {
        return $content . StringUtils::EOL;
    }

    /**
     * @param array $attrs
     * @return string string
     */
    public function stringifyAttrs($attrs)
    {
        $map = array_map(
            static function ($key, $value) {
                return sprintf('%s="%s"', $key, $value);
            },
            array_keys($attrs),
            array_values($attrs)
        );

        return implode(StringUtils::SPACE, $map);
    }

    /**
     * @param string $expression
     * @return string
     */
    public function expr($expression)
    {
        return $expression;
    }

    public function stylesheet($href, $attrs = [])
    {
        $href  = $this->sanitizeUrl($href, self::STYLESHEET_URL_TEMPLATE);
        $attrs = array_merge(['href' => $href, 'rel' => 'stylesheet',], $attrs);

        return $this->render(sprintf('<link %s/>', $this->stringifyAttrs($attrs)));
    }

    public function favicon($url)
    {
        $url   = $this->sanitizeUrl($url);
        $attrs = $this->stringifyAttrs(
            [
                'rel'  => 'icon',
                'href' => $url,
            ]
        );

        return $this->render(sprintf('<link %s>', $attrs));
    }
}
