<?php

namespace Tests\Unit;

use App\Container;
use App\Exceptions\Container\ContainerException;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentGatewayServiceInterface;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new Container();
    }

    /** @test */
    public function it_has_entries_array_property()
    {
        $class = new class() extends Container {
            public function getEntries()
            {
                return $this->entries;
            }
        };

        $this->assertObjectHasProperty('entries', $class);
        $this->assertIsArray($class->getEntries());
    }

    /** @test */
    public function it_stores_set_entry_in_entries_array()
    {
        $class = new class() {
        };

        $this->container->set($class::class, fn() => 'a');

        $this->assertTrue($this->container->has($class::class));
    }

    /** @test */
    public function it_gets_the_entry_value_with_callable_type()
    {
        $this->container->set('a', fn() => 'b');

        $result = $this->container->get('a');

        $this->assertSame($result, 'b');
    }

    /** @test */
    public function it_gets_the_entry_value_with_class_type()
    {
        $this->container->set(PaymentGatewayServiceInterface::class, PaymentGatewayService::class);

        $result = $this->container->get(InvoiceService::class);

        $this->assertInstanceOf(InvoiceService::class, $result);
    }

    /** @test */
    public function it_returns_new_instance_if_class_has_no_constructor()
    {
        $class = new class() {
        };

        $result = $this->container->get($class::class);
        $reflectionClass = new \ReflectionClass($result);

        $this->assertSame($reflectionClass->getConstructor(), null);
        $this->assertEquals($class, $result);
    }

    /** @test */
    public function it_returns_new_instance_if_class_constructor_has_no_parameters()
    {
        $class = new class() {
            public function __construct()
            {
            }
        };

        $result = $this->container->get($class::class);
        $reflectionClass = new \ReflectionClass($result);

        $this->assertEmpty($reflectionClass->getConstructor()?->getParameters());
        $this->assertEquals($class, $result);
    }

    /**
     * @test
     * @dataProvider \Tests\Unit\DataProviders\ContainerDataProvider::throwExceptionProviders
     */
    public function it_throws_container_exception(string $fullyQualifiedName)
    {
        $this->expectException(ContainerException::class);
        $this->container->get($fullyQualifiedName);
    }
}