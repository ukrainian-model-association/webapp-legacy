<?php

use App\DB\Query;
use Symfony\Component\HttpFoundation\Request;

load::app('modules/people/controller');

load::model('user/profile');

/**
 * @property array     collection
 * @property int       limit
 * @property pager     pager
 * @property Paginator paginator
 * @property int       countOfMembers
 * @property array     $holdPeople
 */
class people_index_action extends people_controller
{
    const ITEMS_PER_PAGE = 24;

    const FILTER_ALL                 = '';
    const FILTER_SUCCESSFUL_MODELS   = 'successful-models';
    const FILTER_ASSOCIATION_MEMBERS = 'members-of-association';
    const FILTER_MODELSCOM_MODELS    = 'modelscom-models';
    const FILTER_INSTAGRAM_MODELS    = 'instagram-models';
    const FILTERS                    = [
        self::FILTER_SUCCESSFUL_MODELS   => 'Самые успешные',
        self::FILTER_MODELSCOM_MODELS    => 'Models.com',
        self::FILTER_ASSOCIATION_MEMBERS => 'Члены ассоциации',
        self::FILTER_INSTAGRAM_MODELS    => 'instagram',
        self::FILTER_ALL                 => 'Все',
    ];

    private $filter;

    public function execute()
    {
        parent::execute();

        $request = Request::createFromGlobals();
        $this->handleRequest($request);
    }

    // /**
    //  * @param Request $request
    //  */
    // private function handleRequest($request)
    // {
    //     $uri    = $request->getRequestUri();
    //     $method = $request->getMethod();
    //
    //     switch (true) {
    //         case Request::METHOD_GET === $method:
    //             return $this->index((int) $request->request->get('page', 1), $request->request->get('filter'));
    //
    //         case Request::METHOD_POST === $method && $uri === '':
    //             return;
    //
    //     }
    // }

    /**
     * @return string|null
     */
    public function getFilter()
    {
        return $this->filter;
    }

    protected function getRoutes()
    {
        return [
            function (Request $request) {
                if (Request::METHOD_GET !== $request->getMethod()) {
                    return false;
                }

                $page   = (int) $request->get('page', 1);
                $filter = $request->get('filter');

                $this->index($page, $filter);

                return true;
            },
            function (Request $request) {
                if (
                    Request::METHOD_POST !== $request->getMethod() ||
                    !preg_match('/^\/people\/set-partial-ordering$/', $request->getRequestUri())
                ) {
                    return false;
                }

                $mainSet  = $request->get('data', []);
                $extraSet = $request->get('hold', []);

                $this->set_renderer('ajax');
                $this->json = [
                    '$mainSet' => $mainSet,
                    '$extraSet' => $extraSet,
                    'result' => $this->setPartialOrdering($mainSet, $extraSet) ? 'true' : 'false',
                ];


                return true;
            },
        ];
    }

    public function index($currentPage, $filter)
    {
        $collection           = $this->getCollection($filter);
        $pager                = pager_helper::get_pager($collection, $currentPage, self::ITEMS_PER_PAGE);
        $this->paginator      = PaginatorFactory::create($collection);
        $this->collection     = $pager->get_list();
        $this->countOfMembers = $pager->get_total();
        $this->holdPeople     = session::get('hold_people', []);
    }

    /**
     * @param string $filter
     *
     * @return array
     */
    private function getCollection($filter)
    {
        $query = $this->createDBQuery();

        if (array_key_exists($filter, self::FILTERS)) {
            $this->filter = $filter;
        }

        switch ($filter) {
            case self::FILTER_SUCCESSFUL_MODELS:
                return $query
                    ->setSql(sprintf('%s and ua.successful_model = :only_successful order by ud.rank', $query->getSql()))
                    ->setParameter('only_successful', true)
                    ->execute();

            case self::FILTER_ASSOCIATION_MEMBERS:
                return $query
                    ->setSql(sprintf('%s and ua.member_of_association = :only_assoc_members order by ud.rank', $query->getSql()))
                    ->setParameter('only_assoc_members', true)
                    ->execute();

            case self::FILTER_MODELSCOM_MODELS:
                return $query
                    ->setSql('select ua.id from user_auth ua left join user_contacts as uc on uc.user_id = ua.id where ua.type = :type and ua.hidden = :hidden and ua.del = :del and ua.reserv = :reserv and uc.key = :contact_type and uc.value != \'\'')
                    ->setParameter('contact_type', 'modelscom')
                    ->execute();

            case self::FILTER_INSTAGRAM_MODELS:
                return $query
                    ->setSql('select iup.user_id, max(iup.followers_count) as cnt from instagram_user_profile iup join user_auth ua on ua.id = iup.user_id where ua.type = :type and ua.hidden = :hidden and ua.del = :del and ua.reserv = :reserv group by iup.user_id order by cnt desc;')
                    ->execute();
        }

        return $query->execute();
    }

    /**
     * @return Query
     */
    private function createDBQuery()
    {
        $sql = 'select ua.id from user_auth ua join user_data ud on ud.user_id = ua.id where ua.type = :type and ua.hidden = :hidden and ua.del = :del and ua.reserv = :reserv';

        return Query::create($sql, [
            'type'   => profile_peer::MODEL_TYPE,
            'hidden' => false,
            'del'    => 0,
            'reserv' => 0,
        ]);
    }

    /**
     * @param array $mainSet
     * @param array $extraSet
     *
     * @return bool
     */
    public function setPartialOrdering($mainSet, $extraSet)
    {
        if (!session::has_credential('admin')) {
            return false;
        }

        session::set('hold_people', $extraSet);

        array_walk($mainSet, function ($data) {
            user_data_peer::instance()->update($data);
        });

        return true;
    }

    private function execute1()
    {
        parent::execute();

        $act = request::get('act');
        if (in_array($act, ['set_limit', 'set_rank'])) {
            $this->set_renderer('ajax');

            return $this->json['success'] = $this->$act();
        }

        $this->status = request::get('status');
        switch ($this->status) {
            case 'new-face':
                $sqladd = sprintf(' AND show_on_main >= %s AND show_on_main < %s', user_auth_peer::NEW_FACES, user_auth_peer::PERSPECTIVE);
                break;

            case 'perspective':
                $sqladd = sprintf(' AND show_on_main >= %s AND show_on_main < %s', user_auth_peer::PERSPECTIVE, user_auth_peer::LEGENDARY);
                break;

            case 'successful':
                $sqladd = sprintf(' AND show_on_main > %s AND show_on_main < %s', user_auth_peer::SUCCESSFUL, user_auth_peer::NEW_FACES);
                break;

            case 'legendary':
                $sqladd = sprintf(' AND show_on_main >= %s', user_auth_peer::LEGENDARY);
                break;

            default:
                $sqladd = '';
                break;
        }


        $this->filter = request::get('filter');
        if (!$this->filter) {
            $this->filter = 'model';
        }

        $this->type_key = profile_peer::get_type_key($this->filter);

        $sql        = 'SELECT id FROM user_auth WHERE type=:type AND hidden=:hidden AND del=:del AND reserv=:reserv';
        $coditional = [
            'type'   => $this->type_key,
            //				'active' => true,
            'hidden' => false,
            'del'    => 0,
            'reserv' => 0,
        ];

        if (session::has_credential('admin')) {
            $sql        = 'SELECT id FROM user_auth WHERE type=:type AND del=:del AND hidden=:hidden AND reserv=:reserv';
            $coditional = [
                'type'   => $this->type_key,
                'hidden' => 0,
                'del'    => 0,
                'reserv' => 0,
            ];
        }

        if ('modelscom' === $this->status) {
            $sql        = <<<HEREDOC
select ua.id from user_auth as ua
    left join user_contacts as uc on uc.user_id = ua.id
where uc.key = 'modelscom'
  and uc.value != ''
  and ua.type = :type
  and ua.del = :del
  and ua.hidden = :hidden
  and ua.reserv = :reserv;
HEREDOC;
            $coditional = [
                'type'   => $this->type_key,
                'hidden' => 0,
                'del'    => 0,
                'reserv' => 0,
            ];
        }

        $hold             = session::get('hold_people', []);
        $this->holdPeople = $hold;
        $this->list       = [];

        if (null !== ($byInstagram = $this->getByInstagram())) {
            $this->list = $byInstagram;
        } elseif (null !== ($byMilestone = $this->getByMilestone(request::get_int('milestone', null)))) {
            $ua_list = $byMilestone;
        } else {
            $ua_list = db::get_cols($sql . $sqladd, $coditional);
            $ud_list = user_data_peer::instance()->get_list([], [], ['rank ASC']);

            foreach ($ud_list as $ud_item) {
                if (in_array($ud_item, $ua_list, true) && !in_array($ud_item, $hold, true)) {
                    $this->list[] = $ud_item;
                }
            }
        }

        $page        = request::get('page');
        $this->limit = 24;

        $this->paginator = PaginatorFactory::create($this->list);

        $this->pager         = pager_helper::get_pager($this->list, $page, $this->limit);
        $this->count_members = $this->pager->get_total();
        $this->count_pages   = $this->pager->get_pages();
        $this->list          = $this->pager->get_list();

    }

    private function getByInstagram()
    {
        if ('instagram' !== request::get('status')) {
            return null;
        }

        $sql = <<<SQL
select p.user_id
from instagram_user_profile as p
         left join user_auth a on p.user_id = a.id
where p.followers_count > 0
  and a.type = 2
  and a.del = 0
  and a.reserv = 0
  and a.hidden = false
order by p.followers_count desc
SQL;

        return db::get_cols($sql);
    }

    private function getByMilestone($milestone = null)
    {
        $sql = <<<SQL
select ua.id
from user_auth as ua
where ua.del = :del
  and ua.reserv = :reserv
  and ua.milestone = :milestone;
SQL;

        if (null !== $milestone) {
            return db::get_cols($sql, [
                'del'       => 0,
                // 'hidden'    => false,
                'reserv'    => 0,
                'milestone' => $milestone,
            ]);
        }

        return null;
    }

    private function set_limit()
    {
        $limit = request::get_int('limit');
        session::set('people.limit', $limit);

        return $limit;
    }

    private function set_rank()
    {
        if (!session::has_credential('admin')) {
            return false;
        }

        $data = request::get_array('data');
        $hold = request::get_array('hold');

        session::set('hold_people', $hold);

        foreach ($data as $_data) {
            user_data_peer::instance()->update($_data);
        }

        return true;
    }
}
