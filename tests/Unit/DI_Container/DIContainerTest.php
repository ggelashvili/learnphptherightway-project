<?php

namespace Tests\Unit\DI_Container;

use App\Container;
use App\Exceptions\Container\ContainerException;
use PHPUnit\Framework\TestCase;
use Tests\DataProviders\Outher;

class DIContainerTest extends TestCase
{
    private Container $container;
    public function setUp(): void
    {
        parent::setUp();

        $this->container = new Container();
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\DIContainerDataProvider::setDIContainerEntriesCases
     */
    public function it_sets_new_entry(string $id, callable|string $concrete)
    {
        $this->container->set($id, $concrete);

        $expected = [
            $id => $concrete
        ];

        $this->assertEquals($expected, $this->container->getEntries());
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\DIContainerDataProvider::setDIContainerEntriesCases
     */
    public function it_checks_for_entry(string $id, callable|string $concrete)
    {
        $this->container->set($id, $concrete);
        $this->assertTrue($this->container->has($id));
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\DIContainerDataProvider::DIContainerResolveMethodExceptionCases
     */
    public function resolve_method_throws_exception(string $id)
    {
        $this->expectException(ContainerException::class);
        $this->container->resolve($id);
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\DIContainerDataProvider::DIContainerResolveMethodCases
     */
    public function resolve_method_resolves_the_class(string $id)
    {
        $resoledInstance =$this->container->resolve($id);
        $this->assertInstanceOf($id, $resoledInstance);
    }
}