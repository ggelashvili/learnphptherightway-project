<?php

namespace App;

class Text extends Field
{
    public function render(): string
    {
        return <<<HTML
    <input type="text" name="{$this->name}">
HTML;
    }
}
