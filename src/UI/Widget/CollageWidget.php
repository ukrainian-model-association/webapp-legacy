<?php

namespace App\UI\Widget;

use App\UI\Widget\CollageWidget\CollageBody;
use App\UI\Widget\CollageWidget\CollageHeader;

class CollageWidget
{
    /** @var CollageHeader */
    private $header;

    /** @var CollageBody */
    private $body;

    public function __construct()
    {
    }

    public static function create($ctx)
    {
        $self = (new static())
            ->getBody();

        if (isset($ctx['header'])) {
            $self->setHeader(CollageHeader::create($ctx['header']));
        }

        return $self;
    }

    private function getBody()
    {
        return $this->body;

        return <<<HTML
<div class="main-page-gallery">
    <div class="image-box">
        <?php if ($most) { ?>
            <?php foreach ($most as $k => $v) {
                $baseUrl = sprintf('https://%s', conf::get('server'));
                $urlPath = 'no_image.png';

                if ($v['ph_crop']) {
                    $c       = unserialize($v['ph_crop']);
                    $urlPath = sprintf('imgserve?pid=%s&w=%s&h=%s&x=%s&y=%s&z=crop', $v['pid'], $c['w'], $c['h'], $c['x'], $c['y']);
                }

                $imgSrc = sprintf('%s/%s', $baseUrl, $urlPath);

                ?>
                <a href="/profile?id= $v['id'] " data-user-id=" $v['id'] ">
                    <img src=" $imgSrc "  ($k % 10 === 0 && $k) ? 'style="margin-right: 0px;"'
                        : ($i === 0 ? 'style="margin-left: 0px;"' : '') >

                     $tooltip_style = [
                        'position: absolute',
                        'background: black',
                        'color: white',
                        'border-radius: 5px',
                        'font-size: 11px',
                        'padding: 5px 10px'
                    ]

                    <div data-tooltip=" $v['id'] "
                         class="hide"
                         style="implode('; ', $tooltip_style)"> profile_peer::get_name($v) </div>
                </a>
            <?php } ?>
        <?php } ?>
    </div>
</div>
HTML;

    }

    public function render()
    {
        return <<<HTML
<div>
{$this->getHeader()->render()}
{$this->getBody()->render()}
</div>
HTML;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    private function registerLink($link)
    {
        $checkup = isset($link['checkup']) ? $link['checkup'] : null;

        if (is_callable($checkup) && !$checkup()) {
            return null;
        }

        return <<<HTML
<div class="register-link right">
    <a href="{$link['href']}" class="cpurple">{$link['text']}</a>
</div>
HTML;
    }
}