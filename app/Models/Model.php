<?php

declare(strict_types=1);

namespace App\Models;

use App\App;
use App\DB;

abstract class Model
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }
}
