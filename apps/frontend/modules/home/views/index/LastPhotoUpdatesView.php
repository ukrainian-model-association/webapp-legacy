<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

use App\Component\AbstractView;

/**
 * Class LastPhotoUpdatesView
 */
class LastPhotoUpdatesView extends AbstractView
{
    private $collection;

    /**
     * @param mixed ...$args
     */
    public function willMount(...$args)
    {
//        $sql = <<<SQL
//select id, user_id, category, images
//from user_albums
//where category = 'covers'
//  and images <> 'a:0:{}'
//  and user_id in (select id from user_auth where hidden = false and type = 2)
//order by modified desc
//limit 4;
//SQL;
        //$this->collection = array_map(
        //    static function ($row) {
        //        $row['images'] = unserialize($row['images']);
        //
        //        return [
        //            'user_id' => $row['user_id'],
        //            'id'      => end($row['images']),
        //        ];
        //    },
        //    db::get_rows($sql)
        //);

        $sql = <<<SQL
select pai.*
from person_album pa
         join person_album_image pai on pa.id = pai.album_id
where pa.type = 1
order by pai.created_at desc
limit 4;
SQL;

        $this->collection = array_map(
            static function ($row) {
                return [
                    'user_id' => $row['user_id'],
                    'id'      => $row['resource_id'],
                ];
            },
            db::get_rows($sql, [], 'sfx')
        );
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $photos = array_map([$this, 'renderPhoto'], $this->collection);

        return <<< HTML
<div class="px-3">
    <div class="row">
        <div class="col small-title square_p pl10">
            <a href="/updates">Новые фотографии</a>
        </div>
    </div>
    <div class="row">
        <div class="grid auto-flow-column justify-content-between" style="grid-template-columns: repeat(4, 240px)">
            {$this->renderView($photos)}
        </div>
    </div>
</div>
HTML;
    }

    /**
     * @param array $photo
     *
     * @return string
     */
    private function renderPhoto($photo)
    {
        return <<<HTML
<div style="position: relative">
    <a href="/profile?id={$photo['user_id']}">
        <img alt=""
             class="img-fluid"
             src="/imgserve?pid={$photo['id']}&h=640"
             style="object-fit: cover; width: 100%; height: 320px"/>
    </a>
</div>
HTML;
    }
}

return LastPhotoUpdatesView::createView();
