<?php
declare(strict_types=1);

namespace Freyr\Tests;

use Freyr\ControllerMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Routing\Router;
use Zend\Diactoros\RequestFactory;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class ControllerMiddlewareTest
 * @package Freyr\Tests
 */
class ControllerMiddlewareTest extends TestCase
{
    /**
     * @var ContainerInterface | MockObject
     */
    private $container;
    /**
     * @var Router | MockObject
     */
    private $router;

    protected function setUp(): void
    {
        $this->container = $this->getMockBuilder(ContainerInterface::class)->disableOriginalConstructor()->getMock();
        $this->router = $this->getMockBuilder(Router::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     */
    public function shouldHandleRequest(): void
    {
        $this->router->expects(static::once())->method('match')->willReturn(['_controller' => FakeController::class, '_action' => 'fakeAction']);
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/');
        $handler = $this->getHandler();
        $controllerMiddleware = new ControllerMiddleware($this->container, $this->router);
        $response =$controllerMiddleware->process($request, $handler);
        self::assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @return RequestHandlerInterface
     */
    private function getHandler()
    {
        return new class implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    return new Response();
                }
            };
    }
}
