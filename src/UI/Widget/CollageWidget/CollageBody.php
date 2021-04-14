<?php

namespace App\UI\Widget\CollageWidget;

use Closure;
use db;
use Doctrine\Common\Collections\ArrayCollection;

class CollageBody
{
    /** @var ArrayCollection */
    private $collection;

    public function __construct()
    {
        $this->collection = new ArrayCollection();
    }

    public static function create($ctx)
    {
        return new static();
    }

    public function render()
    {
        return <<<HTML
<div class="main-page-gallery">
    <div class="image-box">
        {$this
            ->getCollection()
            ->map(Closure::fromCallable([$this, 'renderItem']))}
    </div>
</div>
HTML;
    }

    /**
     * @return ArrayCollection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param ArrayCollection $collection
     * @return CollageBody
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    private function getItem($id)
    {
        $sql = <<<SQL
select
ua.id,
concat_ws(' ', ud.first_name, ud.last_name) as full_name,
format('', 'World')
from user_auth ua
         join user_data ud on ud.user_id = ua.id
where ua.id = :id
SQL;

        return db::get_row(
            $sql,
            [
                'id' => $id,
            ]
        );
    }

    public function renderItem($id)
    {

        $tooltip_style = implode(
            '; ',
            [
                'position: absolute',
                'background: black',
                'color: white',
                'border-radius: 5px',
                'font-size: 11px',
                'padding: 5px 10px',
            ]
        );

        return <<<HTML
<a href="/profile?id={$profile['id']}" data-user-id="{$item['id']}">
    <img src="{$profile['id']}" alt="...">
    <div data-tooltip="{$profile['id']}" class="hide" style="{$tooltip_style}">{$profile['avatar_url']}</div>
</a>
HTML;
    }


}