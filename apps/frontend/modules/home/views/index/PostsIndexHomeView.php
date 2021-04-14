<?php

use App\Component\AbstractView;
use App\Entity\Post;
use App\Repository\PostRepository;
use PhpCollection\Set;

/**
 * Class BlogPostView
 */
class PostsIndexHomeView extends AbstractView
{
    const HEADER_URI_TEMPLATE = '/news?type=%d';
    const POST_URI_TEMPLATE = '/news/view?id=%d';
    const POST_COVER_URI_TEMPLATE = 'https://img.%s/m/%s.jpg';

    /** @var PostRepository */
    private $repo;

    /** @var Set */
    private $postSet;

    public function __construct()
    {
        $this->repo = new PostRepository();
    }

    public function willMount()
    {
        $this->postSet = $this->repo->getLast4Publications();
    }

    public function render()
    {
        return <<<HTML
<div class="home-index-posts mt-1 mb-3">
    <div class="small-title square_p pl10 mb5">
        <a href="{$this::makeHeaderUri()}">Публикации</a>
    </div>
    <div class="grid g-3">
        {$this->renderView(
            $this->postSet
                ->map($this->postView())
                ->all()
        )}
    </div>
</div>
HTML;
    }

    private static function makeHeaderUri()
    {
        return sprintf(self::HEADER_URI_TEMPLATE, Post::TYPE_PUBLICATION);
    }

    /**
     * @return Closure
     */
    private function postView()
    {
        /**
         * @param Post $post
         *
         * @return string
         */
        return function ($post) {
            return <<<HTML
<article style="background-image: url('{$this::makePostCoverUri($post)}')">
    <div class="post-body">
        <a href="{$this::makePostUri(
                $post
            )}" class="post-title" style="text-shadow: 1px 1px 4px rgba(0,0,0,.5)">{$post->getTitle()}</a>
    </div>
    <div class="post-body w-auto px-0 py-3" style="right: 1rem">
        <div class="badge badge-dark">{$post->getCreatedAt()->format('d.m.Y')}</div>
    </div>
</article>
HTML;
        };
    }

    /**
     * @param Post $post
     *
     * @return string
     */
    private static function makePostCoverUri($post)
    {
        return sprintf(self::POST_COVER_URI_TEMPLATE, conf::get('server'), $post->getSalt());
    }

    /**
     * @param Post $post
     *
     * @return string
     */
    private static function makePostUri($post)
    {
        return sprintf(self::POST_URI_TEMPLATE, $post->getId());
    }

    /**
     * @param Post $post
     *
     * @return string
     */
    private function coverOfPostView($post)
    {
        return <<<HTML
<a href="{$this::makePostUri($post)}">
    <img alt="{$post->getTitle()}" src="{$this::makePostCoverUri($post)}" class="brief-img" style="height: 45vw">
</a>
HTML;
    }
}

return PostsIndexHomeView::createView();
