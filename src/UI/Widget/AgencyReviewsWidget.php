<?php

namespace App\UI\Widget;

use Twig\Environment as Twig;
use Exception;

class AgencyReviewsWidget
{
    /** @var Twig */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public static function create($di)
    {
        return new self($di->get(Twig::class));
    }

    public function __toString()
    {
        try {
            return $this->twig->render('widget/agency_reviews_widget.twig');
        } catch (Exception $e) {
            return sprintf('<pre>%s</pre>', $e->getMessage());
        }
    }
}
