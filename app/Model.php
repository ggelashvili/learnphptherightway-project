<?php

declare(strict_types = 1);

namespace App;

abstract class Model
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }
}

class Transaction extends Model
{
    public function create($values)
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS transactions (date VARCHAR(255), check_ INT, description VARCHAR(255), amount VARCHAR(255));");
        $stmt = $this->db->prepare("INSERT INTO transactions (date, check_, description, amount) VALUES (:date, :check_, :description, :amount)");
        $stmt->bindParam(":date", $values[0]);
        $values[1] = (int) $values[1];
        $stmt->bindParam(":check_", $values[1]);
        $stmt->bindParam(":description", $values[2]);
        $stmt->bindParam(":amount", $values[3]);
        $stmt->execute();
    }
    public function getData()
    {
        return $this->db->query("SELECT * FROM transactions;")->fetchAll();
    }
}