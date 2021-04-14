<?php


namespace App\Component;


interface IView
{
    /**
     * @return mixed
     */
    public function __toString();

    /**
     * @return string
     */
    public function render();
}
