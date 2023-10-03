<?php

declare(strict_types=1);

use App\ClassA;
use App\MyClass;
use App\MyTrait;

require __DIR__ . '/../vendor/autoload.php';

//$obj = new class(1, 2 ,3) extends MyClass implements \App\MyInterface {
//    use MyTrait;
//    public function __construct(public int $x, public int $y, public int $z)
//    {
//        parent::__construct();
//    }
//};
//function foo(\App\MyInterface $obj)
//{
//    return $obj;
//}
//
//
//var_dump(foo($obj));
//var_dump(get_class($obj));

$obj = new ClassA(1, 2);
var_dump($obj->bar());
