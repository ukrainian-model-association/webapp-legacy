<?php


namespace App\Repository;

use App\Entity\Post;
use db;
use PhpCollection\Set;
use session;

class PostRepository
{
    /**
     * @return Set
     */
    public function getLast4Publications()
    {
        $query  = '
            SELECT id, title, created_ts, salt
            FROM news
            WHERE type = :type
              AND hidden = :hidden
            ORDER BY created_ts DESC
            LIMIT 4
        ';
        $params = [
            'type'   => Post::TYPE_PUBLICATION,
            'hidden' => 0,
        ];

        $rows = db::get_rows($query, $params);

        return $this->createSet($rows);
    }

    /**
     * @param array $rows
     *
     * @return Set
     */
    private function createSet($rows)
    {
        return new Set(array_map([$this, 'mapToEntity'], $rows));
    }

    private function mapToEntity($data)
    {

        $language  = session::get('language', 'ru');
        $entity    = new Post();
        $fieldsMap = [
            'id'         => 'setId',
            'title'      => 'setTitle',
            'body'       => 'setContent',
            'anons'      => 'setAnnouncement',
            'models'     => 'setModels',
            'created_ts' => 'setCreatedAt',
            'salt'       => 'setSalt',
        ];

        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $fieldsMap)) {
                continue;
            }

            if (in_array($key, ['title', 'body', 'anons', 'models'], true)) {
                $value = unserialize($value);
                if ('models' !== $key) {
                    $value = stripslashes($value[$language]);
                }
            }

            if ('created_ts' === $key) {
                $value = date('Y-m-d H:i:s', $value);
            }

            $entity->{$fieldsMap[$key]}($value);
        }

        return $entity;
    }
}
