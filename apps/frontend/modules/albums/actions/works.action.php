<?php

load::app('modules/albums/controller');

/**
 * @property array works
 * @property array categories
 */
class albums_works_action extends albums_controller
{
    public function execute()
    {
        parent::execute();

        $this->categories = user_albums_peer::get_categories();
        unset($this->categories['portfolio']);

        $this->works = [];
        foreach ($this->categories as $category_key => $category) {
            $cond = [
                'user_id' => $this->uid,
                'category' => $category_key,
            ];

            $albums_id = user_albums_peer::instance()->get_list($cond);
            $this->works[$category_key] = [];

            if ($category_key === 'covers') {
                $album = user_albums_peer::instance()->get_item($albums_id[0]);
                $album['images'] = unserialize($album['images']);
                foreach ($album['images'] as $pid) {
                    $photo = user_photos_peer::instance()->get_item($pid);
                    $ad = unserialize($photo['additional']);
                    $this->works[$category_key][] = [
                        'id' => $album['id'],
                        'name' => $photo['name'],
                        'images' => [$pid],
                    ];
                }
                if (count($this->works[$category_key]) === 0) {
                    $this->works[$category_key][0]['id'] = $album['id'];
                }
            } else {
                foreach ($albums_id as $album_id) {
                    $album = user_albums_peer::instance()->get_item($album_id);
                    $album['images'] = unserialize($album['images']);
                    $album['additional'] = unserialize($album['additional']);
                    $this->works[$category_key][] = $album;
                }
            }
            $this->works[$category_key] = array_splice($this->works[$category_key], 0, 5);
        }
    }
}
