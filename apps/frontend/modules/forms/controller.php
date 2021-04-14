<?php

use Symfony\Component\HttpFoundation\Request;

abstract class forms_controller extends frontend_controller
{
    /**
     * @var Request
     */
    private $request;

    public function __construct($module, $action)
    {
        parent::__construct($module, $action);

        $this->request = Request::createFromGlobals();
    }

    public function execute()
    {
        list($function, $parameters) = $this->resolveRoute($this->request->getRequestUri());

        $function($this->request, $parameters);
    }

    /**
     * @param string $requestUri
     *
     * @return array
     */
    final public function resolveRoute($requestUri)
    {
        foreach ($this->getRoutes() as $regex => $route) {
            if (!preg_match($regex, $requestUri, $parameters)) {
                continue;
            }

            $parameters = array_filter($parameters, function ($value, $parameter) {
                return is_string($parameter);
            }, ARRAY_FILTER_USE_BOTH);

            return [$route, $parameters];
        }
    }

    /**
     * @return array
     */
    abstract public function getRoutes();

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $view
     *
     * @return self
     */
    protected function setView($view)
    {
        $this->set_template($view);

        return $this;
    }
}
