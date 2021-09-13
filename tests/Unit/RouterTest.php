<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
    }

    /** @test */
    public function it_registers_a_route(): void
    {
        $this->router->register('get', '/users', ['Users', 'index']);

        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }

    /** @test */
    public function it_registers_a_get_route(): void
    {
        $this->router->get('/users', ['Users', 'index']);

        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }

    /** @test */
    public function it_registers_a_post_route(): void
    {
        $this->router->post('/users', ['Users', 'store']);

        $expected = [
            'post' => [
                '/users' => ['Users', 'store'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }

    /** @test */
    public function there_are_no_routes_when_router_is_created(): void
    {
        $this->assertEmpty((new Router())->routes());
    }

    /**
     * @test
     * @dataProvider routeNotFoundCases
     */
    public function it_throws_route_not_found_exception(
        string $requestUri,
        string $requestMethod
    ): void {
        $users = new class() {
            public function delete(): bool
            {
                return true;
            }
        };

        $this->router->post('/users', [$users::class, 'store']);
        $this->router->get('/users', ['Users', 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

    public function routeNotFoundCases(): array
    {
        return [
            ['/users', 'put'],
            ['/invoices', 'post'],
            ['/users', 'get'],
            ['/users', 'post'],
        ];
    }

    /** @test */
    public function it_resolves_route_from_a_closure(): void
    {
        $this->router->get('/users', fn() => [1, 2, 3]);

        $this->assertSame(
            [1, 2, 3],
            $this->router->resolve('/users', 'get')
        );
    }

    /** @test */
    public function it_resolves_route(): void
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
}
