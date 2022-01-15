<?php
declare(strict_types=1);

namespace App\Models;
use App\App;
use DateTime;use App\DB;
class Model{
    
    protected static DB $db;
    public function __construct(){
        static::$db = App::db();
    }

    public function strToDateTime(string $date): DateTime{
        return DateTime::createFromFormat("m/d/Y", $date);
    }

    public function strToInt(string $check){
        return intval($check) ?? 0;
    }

    public function strToFloat(string $amount){
        return (float) str_replace(['$', ','], '', $amount);
    }
}

