<?php

namespace App;

class Checkbox extends Boolean
{
    public function render(): string
    {
        return <<<HTML
    <input type="checkbox" name="{$this->name}">
HTML;
    }
}
