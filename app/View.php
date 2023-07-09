<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\FileNotExistException;
use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected string $view,
        protected array  $params = [])
    {


    }

    public static function make(string $view, array $params = []): static
    {
        return new static($view, $params);
    }

    public function render(): string
    {
        foreach ($this->params as $key=>$value)
        {

            $$key=$value;

        }

        $view_path = VIEWS_PATH . '/' . $this->view . '.php';
        if (!file_exists($view_path)) {
            throw new FileNotExistException();
        }
        ob_start();
        include $view_path;
        return (string)ob_get_clean();
    }

    public function __toString()
    {
        return $this->render();
    }



    static function dollar_format(float $amount): string
    {
        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }


    static function date__format(string $date): string
    {
        return date('M j, Y', strtotime($date));
    }

}

