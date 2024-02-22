<?php

namespace Tests\Unit;

use App\Container;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class ContainerTest extends TestCase
{
    #[Test]
    public function it_has_existing_entry()
    {
        $container = new Container();
        $container->set('testService', function () {
        });
        $this->assertTrue($container->has('testService'));
    }

    #[Test]
    public function it_has_not_non_existing_entry()
    {
        $container = new Container();
        $this->assertFalse($container->has('nonExistingTestService'));
    }

    #[Test]
    public function it_sets_callable_entry()
    {
        $container = new Container();
        $container->set('testService', function () {
            return new class {
            };
        });
        $this->assertTrue($container->has('testService'));
        try {
            $this->assertNotNull($container->get('testService'));
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface|ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }

    #[Test]
    public function it_sets_class_string_entry()
    {
        $testService = new class {
        };
        $container   = new Container();
        $container->set('testService', $testService::class);
        $this->assertTrue($container->has('testService'));
        try {
            $this->assertInstanceOf(
                $testService::class,
                $container->get('testService')
            );
        } catch (NotFoundExceptionInterface|ReflectionException|ContainerExceptionInterface $e) {
            $this->fail($e->getMessage());
        }
    }


    #[Test]
    public function it_instantiates_dependency_by_passed_classname_when_get_is_called(
    )
    {
        $testService = new class {
        };
        $container   = new Container();
        try {
            $this->assertInstanceOf(
                $testService::class,
                $container->get($testService::class)
            );
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface|ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }

    #[Test]
    public function it_instantiates_all_dependencies_in_the_dependency()
    {
        $container = new Container();
        /** @var DependedService $dependedService */
        try {
            $dependedService = $container->get(DependedService::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface|ReflectionException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertInstanceOf(DependedService::class, $dependedService);
        $this->assertInstanceOf(
            TestService::class,
            $dependedService->testService
        );
    }

    #[Test]
    public function it_throws_not_found_exception_when_trying_to_get_non_existing_class(
    )
    {
        $container = new Container();
        $this->expectException(NotFoundExceptionInterface::class);
        $container->get('testService');
    }

    #[Test]
    public function it_throws_container_exception_with_correct_message_when_no_type_hint_dependency_is_provided(
    )
    {
        $container = new Container();

        $this->expectException(ContainerExceptionInterface::class);
        $this->expectExceptionMessage(
            'Failed to resolve class "'.ClassWithNoTypeHintDependency::class
            .'" because param "'.'invalidDependency'.'" is missing a type hint'
        );
        $container->get(ClassWithNoTypeHintDependency::class);
    }

    #[Test]
    public function it_throws_container_exception_with_correct_message_when_builtin_type_dependency_is_provided(
    )
    {
        $container = new Container();

        $this->expectException(ContainerExceptionInterface::class);
        $this->expectExceptionMessage(
            'Failed to resolve class "'.ClassWithBuiltInTypeDependency::class
            .'" because invalid param "'.'invalidDependency'.'"'
        );
        $container->get(ClassWithBuiltInTypeDependency::class);
    }

    #[Test]
    public function it_throws_container_exception_with_correct_message_when_type_union_dependency_is_provided(
    )
    {
        $container = new Container();

        $this->expectException(ContainerExceptionInterface::class);
        $this->expectExceptionMessage(
            'Failed to resolve class "'.ClassWithUnionDependency::class
            .'" because of union type for param "'.'invalidDependency'.'"'
        );
        $container->get(ClassWithUnionDependency::class);
    }
}

class TestService
{

}

class DependedService
{

    public function __construct(public TestService $testService)
    {
    }


}

class ClassWithNoTypeHintDependency
{
    public function __construct(public $invalidDependency)
    {
    }
}

class ClassWithUnionDependency
{
    public function __construct(
        public TestService|DependedService $invalidDependency
    ) {
    }
}

class ClassWithBuiltInTypeDependency
{
    public function __construct(
        public int $invalidDependency
    ) {
    }
}
