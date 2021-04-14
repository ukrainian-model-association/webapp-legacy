<?php


namespace App\Bootstrap\Components;


class CardGroup
{
    private $cards;

    public static function create($cards = [])
    {
        return new self($cards);
    }

    public function __construct($cards)
    {
        $this->cards = $cards;
    }

    public function __toString()
    {
        return sprintf('<div class="card-group"></div>');
    }

    public function addCard()
    {
        $this->cards[] = Card::create();

        return $this;
    }
}
