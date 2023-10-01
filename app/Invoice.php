<?php

declare(strict_types=1);

namespace App;

class Invoice
//    implements \Stringable
{
//    protected float $amount;
//    protected array $data = [];
//
////    public function __construct(float $amount)
////    {
////        $this->amount = $amount;
////    }
//
//    public function __get(string $name)
//    {
//        if (array_key_exists($name, $this->data)) {
//            return $this->data[$name];
//        }
//
//        return null;
//    }
//
//    public function __set(string $name, $value): void
//    {
//        $this->data[$name] = $value;
//    }
//
//    public function __isset(string $name): bool
//    {
//        var_dump('isset');
//        return array_key_exists($name, $this->data);
//    }
//
//    public function __unset(string $name): void
//    {
//        var_dump('unset');
//        unset($this->data[$name]);
//    }

//    protected function process(float $amount, $description)
//    {
//        var_dump($amount, $description);
//    }
//
//    public function __call(string $name, array $arguments)
//    {
//        if (method_exists($this, $name)) {
//            call_user_func_array([$this, $name], $arguments);
//        }
//    }
//
//    public static function __callStatic(string $name, array $arguments)
//    {
//        var_dump('Static', $name, $arguments);
//    }

//    public function __toString(): string
//    {
//        return '1';
//    }

//    public function __invoke()
//    {
//        var_dump('invoked');
//    }

    private float $amount;
    private int $id = 1;
    private string $accountNumber = '4524681515';

    public function __debugInfo(): ?array
    {
        return [
            'id' => $this->id,
            'accountNumber' => '****' . substr($this->accountNumber, -4),
        ];
    }
}
