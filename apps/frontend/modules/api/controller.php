<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

include_once __DIR__ . '/core/Route.php';

/**
 * Class api_controller
 *
 * @property array json
 */
abstract class api_controller extends frontend_controller
{
    public function execute()
    {
        $request = Request::createFromGlobals();
        $route   = $this->resolveRoute($request->getRequestUri());
        /** @var Response|array $response */
        $response = call_user_func_array($route->getTarget(), array_merge($route->getArgs(), [$request]));

        if ($response instanceof Response) {
            die($response->send());
        }

        $this->disable_layout();
        $this->set_renderer('ajax');
        $this->json = $response;
    }

    /**
     * @param string $requestUri
     *
     * @return Route
     */
    final public function resolveRoute($requestUri)
    {
        foreach ($this->getRoutes() as $regex => $route) {
            if (!preg_match($regex, $requestUri, $args)) {
                continue;
            }

            $request = new Route();
            $request->setTarget(
                $route[0],
                array_map(
                    static function ($key) use ($args) {
                        return $args[$key];
                    },
                    $route[1]
                )
            );

            return $request;
        }
    }

    /**
     * @return array
     */
    abstract public function getRoutes();
}
