<?php

namespace App\Models;

use App\Model;

class TransactionModel extends Model
{


    public function create(array $columns, array $data)
    {
        $ids = [];
        try {
            $q = "INSERT INTO transactions (date, check_number, description, amount)
        VALUES(?,?,?,?)";
            $stmt = $this->db->prepare($q);
            foreach ($data as $key => $value) {

                $check_number = $value[1] === '' ? null : $value[1];
                $params = [
                    \DateTime::createFromFormat('m/d/Y', $value[0])->format('Y-m-d H:i:s'),
                    $check_number,
                    $value[2],
                    (float) preg_replace('/[^-\d.]/', '', $value[3])
                ];

                $stmt->execute($params);
                $ids[] = $this->db->lastInsertId();
                $stmt->closeCursor();
            }
            return $ids;
        } catch (\PDOException $e) {
            echo  $e->getMessage();
        }
    }
    public   function all()
    {
        try {
            $q = 'Select * from transactions';
            $transactions =   $this->db->query($q);
            return $transactions->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
