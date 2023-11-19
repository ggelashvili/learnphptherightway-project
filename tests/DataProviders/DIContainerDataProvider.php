<?php

namespace Tests\DataProviders;

class DIContainerDataProvider
{
    /**
     * @return array[]
     */
    public static function setDIContainerEntriesCases(): array
    {
        return [
            [get_class(new class {}), fn () => new class {}],
            [get_class(new class {}), get_class(new class implements MyInterface {})]
        ];
    }

    /**
     * @return array[]
     */
    public static function DIContainerResolveMethodExceptionCases(): array
    {
        $class1 = new class (new class {}) {
            public $inner;

            public function __construct($class)
            {
                $this->inner = $class;
            }
        };

        $class2 = new class(55) {
            public function __construct(int $variable)
            {}
        };

        $class3 = new class([1,5]) {
            public function __construct(int|array $variable)
            {}
        };

        return [
            //Case: not instantiable
            [MyInterface::class],

            //Case: missing a type hint
            [get_class($class1)],

            //Case: Built-in param type
            [get_class($class2)],

            //Case: union param type
            [get_class($class3)]
        ];
    }

    /**
     * @return array[]
     */
    public static function DIContainerResolveMethodCases(): array
    {
        $class = new class {
            public function __construct()
            {}
        };

        return [
            //Case: no constructor
            [get_class(new class {})],

            //Case: constructor without params
            [get_class($class)],

            //Case: constructor with not built-in type hinted dependency
            [BigClass::class]
        ];
    }
}

/**
 * Dummy interface created to be used when running tests on `resolve` method,
 * because there is no anonymous interface.
 */
interface MyInterface {}

/***
 *
 * BigClass & SmallClass are just dummy classes
 *  created to use when testing `resolve` method of DI-Container,
 *  because anonymous classes can't be type hinted.
 */
class BigClass {
    public function __construct(private SmallClass $smallClass)
    {}
}

class SmallClass {}