<?php

declare(strict_types=1);

namespace App;

use App\Model;

class Transaction extends Model
{
    public function create($values)
    {
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