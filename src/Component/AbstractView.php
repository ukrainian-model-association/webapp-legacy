<?php


namespace App\Component;


abstract class AbstractView implements IView
{
    public static function createView()
    {
        return new static();
    }

    public function willMount(...$args)
    {

    }

    final public function __invoke(...$args)
    {
        call_user_func_array([$this, 'willMount'], $args);

        return $this;
    }

    final public function __toString()
    {
        $content = $this->render();

        return null !== $content ? $content : '';
    }

    /**
     * @param string|array $view
     *
     * @return string
     */
    public function renderView($view)
    {
        if (is_array($view)) {
            $view = implode(PHP_EOL, $view);
        }

        return $view;
    }
}
