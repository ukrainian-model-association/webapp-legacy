<?php


use App\Component\AbstractView;
use App\Component\Asset\Asset;
use App\Component\Asset\AssetManager;
use App\Component\Asset\AssetTypes;
use App\Component\ServiceContainer;

class PopularityRatingView extends AbstractView
{
    const IMAGE_URL_TEMPLATE = 'https://%s/imgserve?pid=%s&w=%s&h=%s&x=%s&y=%s&z=crop';
    const PHOTO_URL_TEMPLATE = '/imgserve?pid=%s&w=320';

    /** @var array */
    private $pair;

    /** @var bool */
    private $checkVote;

    /**
     * @param array            $pair
     * @param boolean          $checkVote
     * @param ServiceContainer $box
     */
    public function willMount($pair, $checkVote, ServiceContainer $box)
    {
        $this->pair      = $pair;
        $this->checkVote = $checkVote;
        /** @var AssetManager $mng */
        $mng = $box->get(AssetManager::class);

        $asset = new Asset();
        $asset
            ->setType(AssetTypes::JAVASCRIPT)
            ->setUrl('/public/js/app/home/index.js');

        $mng->bind($asset);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $p = $this->pair;

        // if (session::get_user_id() === 4) {
        //     echo '<pre>';
        //     var_dump($p);
        //     die;
        // }

        return <<<HTML
<div class="position-relative" style="height: 400px; border: .1rem solid; padding: 1px; box-sizing: border-box">
    <div class="h6 py-3 mb-0 text-center">Кто красивее?</div>
    <div class="grid cg-1" id="popularity_rating" style="grid-template-columns: repeat(2, 1fr); grid-template-rows: 1fr">
        <div onclick="Home.openProfile(this)" data-side="left" data-user-id="{$p[0]['user_id']}" style="cursor: pointer">
            <img src="{$this->makeImageUrl($p[0])}" data-side="left" alt="..." class="w-100" style="height: 250px; object-fit: cover">
        </div>
        <div onclick="Home.openProfile(this)" data-side="right" data-user-id="{$p[1]['user_id']}" style="cursor: pointer">
            <img src="{$this->makeImageUrl($p[1])}" data-side="right" alt="..." class="w-100" style="height: 250px; object-fit: cover">
        </div>
        <div class="text-center" style="margin-top: -1.5rem">
            <button class="btn border-0"
                    data-side="left"
                    data-object-id="{$p[0]['user_id']}"
                    onclick="Home.handleChoice(this)"
                    style="background-color: black; width: 3rem; height: 3rem">
                <i class="fas fa-thumbs-up text-white" style="font-size: 150%;"></i>
            </button>
        </div>
        <div class="text-center" style="margin-top: -1.5rem">
            <button class="btn border-0"
                    data-side="right"
                    data-object-id="{$p[1]['user_id']}"
                    onclick="Home.handleChoice(this)"
                    style="background-color: black; width: 3rem; height: 3rem">
                <i class="fas fa-thumbs-up text-white" style="font-size: 150%;"></i>
            </button>
        </div>
    </div>
    <div class="text-center position-absolute w-100" style="bottom: .5rem">
        <div class="mb-3 underline">
            <a href="javascript: Home.changePair()">Пропустить</a>
        </div>

        <button class="text-uppercase border-0 text-white px-3 py-2"
                onclick="window.location = '/polls/rating?type=1';"
                style="background-color: black; font-weight: bold">Смотреть рейтинг
        </button>
    </div>
</div>
HTML;
    }

    /**
     * @param array $model
     *
     * @return string
     */
    private function makeImageUrl($model)
    {
        return sprintf(self::PHOTO_URL_TEMPLATE, $model['pid']);
    }
}

return PopularityRatingView::createView();
