<?php

namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tests\DataProviders\RouterDataProvider;

class RouterTest extends TestCase
{
    private Router $router;


    public function test_there_are_no_routes_when_router_is_created()
    {
        $this->assertEmpty((new Router())->routes());
    }

    public function test_it_registers_a_route()
    {
        $this->router = new Router();

        $this->router->register('get', '/users', ['Users', 'index']);

        $excepted = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertEquals($excepted, $this->router->routes());
    }

    public function test_it_registers_a_get_route()
    {
        $this->router = new Router();

        $this->router->get('/users', ['Users', 'index']);

        $excepted = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertEquals($excepted, $this->router->routes());
    }

    public function test_it_registers_a_post_route()
    {
        $this->router = new Router();

        $this->router->post('/users', ['Users', 'save']);

        $excepted = [
            'post' => [
                '/users' => ['Users', 'save'],
            ],
        ];

        $this->assertEquals($excepted, $this->router->routes());
    }

    #[DataProviderExternal(RouterDataProvider::class, 'routeNotFoundCases')]
    public function test_it_throws_route_not_found_exception(
        string $requestUri,
        string $requestMethod
    )
    {
        $users = new class () {
            public function delete(): bool
            {
                return true;
            }

            public function index(): bool
            {
                return true;
            }

            public function store(): true
            {
                return true;
            }
        };

        $this->router->post('/users', [$users::class, 'store']);
        $this->router->get('/users', [$users::class, 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

    public function test_it_resolves_route_from_a_closure()
    {
        $this->router->get('/users', fn() => 'Hello Test!');
        $this->assertSame(
            'Hello Test!',
            $this->router->resolve('/users', 'get')
        );
    }

    public function test_it_resolves_a_route()
    {
        $users = new class() {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };

        $this->router->get('/users', [$users::class, 'index']);

        $this->assertSame(
            [1, 2, 3],
            $this->router->resolve('/users', 'get')
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }
}
