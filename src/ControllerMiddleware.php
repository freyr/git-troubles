<?php
declare(strict_types=1);

namespace Freyr;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Router;
use Zend\Diactoros\Response;

/**
 * Class ControllerMiddleware
 * @package Freyr
 */
class ControllerMiddleware implements MiddlewareInterface
{
    /**
     * @var Router
     */
    private $router;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * HttpKernel constructor.
     * @param ContainerInterface $container
     * @param Router $router
     */
    public function __construct(
        ContainerInterface $container,
        Router $router
    ) {
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $route = $this->router->match($request->getUri()->getPath());
        } catch (RouteNotFoundException $exception) {
            return $this->handleNotFoundResponse($request, $exception);
        }

        return $this->handleResponse($request, $route);
    }

    /**
     * Handles 404 responses with payload generated from
     *
     * @param ServerRequestInterface $request
     * @param RouteNotFoundException $exception
     * @return ResponseInterface
     */
    private function handleNotFoundResponse(ServerRequestInterface $request, RouteNotFoundException $exception): ResponseInterface
    {
        return (new Response())->withStatus(404);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $route
     * @return Response
     */
    private function handleResponse(ServerRequestInterface $request, array $route): Response
    {
        // call request handler to generate response (controllers)
        $controllerClassName = $route['_controller'];
        $controller = new $controllerClassName($this->container, $route);

        /** @var Response $response */
        return call_user_func_array(
            [$controller, $route['_action']],
            []
        );
    }
}
