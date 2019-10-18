<?php
declare(strict_types=1);

namespace Freyr\Tests;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

/**
 * Class FakeController
 * @package Freyr\Tests
 */
class FakeController
{
    /**
     * @return ResponseInterface
     */
    public function fakeAction(): ResponseInterface
    {
        return new Response();
    }
}
