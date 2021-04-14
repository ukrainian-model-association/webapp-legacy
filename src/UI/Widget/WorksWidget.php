<?php

namespace App\UI\Widget;

use App\Component\ServiceContainer;
use App\Component\WorkAlbum\Entity\WorkAlbum;
use DateTimeImmutable;
use Exception;
use geo_peer;
use journals_peer;
use profile_peer;
use Twig\Environment as Twig;
use ui_helper;
use user_albums_peer;

class WorksWidget
{
    /** @var Twig */
    private $twig;

    /** @var int */
    private $userId;

    private $profile;

    public function __construct(Twig $twig, $context)
    {
        $this->twig    = $twig;
        $this->userId  = (int) $context['userId'];
        $this->profile = $context['profile'];
    }

    /**
     * @param ServiceContainer $di
     * @param array $context
     * @return WorksWidget
     */
    public static function create(ServiceContainer $di, array $context)
    {
        return new self($di->get(Twig::class), $context);
    }

    public function __toString()
    {
        try {
            $workAlbums = $this->getWorkAlbums();
            $context    = [
                'geo'        => $this->getGeo(),
                'datetime'   => $this->getDateTimeData(),
                'workTypes'  => $this->getWorkTypes(),
                'workList'   => $workAlbums,
                'chronology' => $this->buildChronologyOfWorks($workAlbums),
                'journals'   => $this->getJournals(),
                'user'       => $this->getAuthorizedUser(),
                'profile'    => $this->getProfile(),
            ];

            return $this->twig->render('widget/works_widget.twig', $context);
        } catch (Exception $e) {
            return sprintf('<pre>%s</pre>', $e->getMessage());
        }
    }

    private function getWorkAlbums()
    {
        $criteria = ['user_id' => $this->getProfile()['user_id']];

        return array_map(
            static function ($id) {
                $album              = user_albums_peer::instance()->get_item($id);
                $album['@category'] = user_albums_peer::get_category($album['category']);

                return $album;
            },
            user_albums_peer::instance()->get_list($criteria)
        );
    }

    private function getGeo()
    {
        return [
            'countries' => array_map(
                static function ($entry) {
                    return [
                        'id'   => $entry['country_id'],
                        'name' => $entry['name'],
                    ];
                },
                geo_peer::instance()->get_countries()
            ),
        ];
    }

    private function getDateTimeData()
    {
        $now     = new DateTimeImmutable();
        $current = new DateTimeImmutable();

        $collection = [];
        while ($now->diff($current)->y < 30) {
            $collection[] = $current;
            $current      = $current->modify('-1 year');
        }

        return [
            'months' => ui_helper::MONTHS,
            'years'  => $collection,
        ];
    }

    private function getWorkTypes()
    {
        return WorkAlbum::getTypes();
    }

    private function buildChronologyOfWorks($albumList)
    {
        /*$transformers1 = [
            '@Default'                    => static function ($album) {
                return [
                    'name' => $album['name'],
                ];
            },
            WorkAlbum::TYPE_CONTEST       => function ($album) {
                $extra = $album['additional'];

                return [
                    'name'  => $extra['event_title'],
                    'month' => $extra['period_month'],
                    'year'  => $extra['period_year'],
                ];
            },
            WorkAlbum::TYPE_CATALOGS      => function ($album) {
                $extra = $album['additional'];

                return [
                    'name'  => $extra['name'],
                    'month' => $extra['period_month'],
                    'year'  => $extra['period_year'],
                ];
            },
            WorkAlbum::TYPE_ADVERTISEMENT => static function ($album) {
                $extra = $album['additional'];

                return [
                    'name'  => $extra['brand'],
                    'month' => $extra['period_month'],
                    'year'  => $extra['period_year'],
                ];
            },
            WorkAlbum::TYPE_COVERS        => static function ($album) {
                $extra   = $album['additional'];
                $journal = $extra['journal'];

                if (array_key_exists('journal', $extra)) {
                    return [];
                }

                return [
                    'name'  => sprintf('%s', $journal['name']),
                    'month' => $journal['month'],
                    'year'  => $journal['year'],
                ];
            },
            WorkAlbum::TYPE_FASHION       => static function ($album) {
                return [
                    'name'  => '',
                    'month' => '',
                    'year'  => '',
                ];
            },
            WorkAlbum::TYPE_DEFILE        => static function ($album) {
                $extra = $album['additional'];

                return [
                    'name'  => sprintf(
                        '%s%s',
                        $extra['designer'] !== '' ? $extra['designer'].', ' : '',
                        $extra['event_title']
                    ),
                    'month' => $extra['period_month'],
                    'year'  => $extra['period_year'],
                ];
            },
        ];*/

        $transformers = [
            WorkAlbum::TYPE_DEFAULT => function ($album) {
                return $this->makeWorkListItem($album);
            },
            WorkAlbum::TYPE_COVERS  => function ($album) {
                return $this->makeWorkListItem($album);
            },
            WorkAlbum::TYPE_DEFILE  => function ($album) {
                return $this->makeWorkListItem($album);
            },
            WorkAlbum::TYPE_ADV     => function ($album) {
                return $this->makeWorkListItem($album);
            },
            WorkAlbum::TYPE_CONTEST => function ($album) {
                return $this->makeWorkListItem($album);
            },
        ];

        return array_filter(
            array_map(
                function ($album) use ($transformers) {
                    $type        = $album['category'];
                    $transformer = $transformers[WorkAlbum::TYPE_DEFAULT];
                    if (array_key_exists($type, $transformers)) {
                        $transformer = $transformers[$type];
                    }

                    if (in_array($type, WorkAlbum::EXCLUDED_TYPES, true)) {
                        return null;
                    }

                    $album['images']     = unserialize($album['images']);
                    $album['additional'] = unserialize($album['additional']);

                    $data             = $transformer($album);
                    $data['id']       = $album['id'];
                    $data['href']     = sprintf(
                        '/albums/album?aid=%s&uid=%s',
                        $album['id'],
                        $this->getProfile()['user_id']
                    );
                    $data['category'] = user_albums_peer::get_category($album['category']);
                    $data['month']    = ui_helper::get_mounth($data['month']);

                    return $data;
                },
                $albumList
            ),
            static function ($workAlbum) {
                return $workAlbum !== null;
            }
        );
    }

    private function getJournals()
    {
        return array_map(
            static function ($id) {
                $journal = journals_peer::instance()->get_item($id);

                return [
                    'id'   => $journal['id'],
                    'name' => sprintf('%s, %s', $journal['name'], $journal['location']),
                ];
            },
            journals_peer::instance()->get_list(['public' => true], [], ['name ASC'])
        );
    }

    private function getAuthorizedUser()
    {
        $userId = $this->getUserId();

        if (!$userId) {
            return null;
        }

        $user       = profile_peer::instance()->get_item($userId);
        $user['id'] = $userId;

        return $user;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function makeWorkListItem($context)
    {
        return [
            '@id'   => sprintf(
                '/albums/album?uid=%s&aid=%s',
                $this->getProfile()['user_id'],
                $context['id']
            ),
            'id'    => $context['id'],
            '@type' => $context['category'],
            'type'  => WorkAlbum::getTypeValue($context['category']),
            'name'  => $context['name'],
            'date'  => '',
        ];
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
