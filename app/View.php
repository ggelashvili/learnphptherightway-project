<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(protected string $view, protected array $params = [])
    {
    }

    public static function make(string $view, array $params = []): static
    {
        return new static($view, $params);
    }

    public function render(): string
    {
        $viewpath = VIEW_PATH . '/' . $this->view . '.php';

        if (! file_exists($viewpath)) {
            throw new ViewNotFoundException();
        }

        foreach ($this->params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include $viewpath;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
