<?php

namespace App;

class Toaster
{
    protected array $slices;
    protected int $size;

    public function __construct()
    {
        $this->slices = [];
        $this->size = 2;
    }

    final public function addSlice(string $slice): void
    {
        if (count($this->slices) < $this->size) {
            $this->slices[] = $slice;
        }
    }

    public function toast()
    {
        foreach ($this->slices as $i => $slice) {
            echo ($i + 1) . ': Toasting ' . $slice . PHP_EOL;
        }
    }

    public function foo()
    {
        
    }
}
