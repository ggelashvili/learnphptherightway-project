<?php

namespace App;

class Model
{
    protected DB $db;
    public function __construct()
    {
        $this->db=Application::db();
    }

}