<?php

declare(strict_types=1);
namespace App\Models;

class Transaction extends \App\Model
{

    public function create(float $amount, string $description,string $created_at,int $check,array $result):void
    {
        $stmt=$this->db->prepare('
        INSERT INTO Transactions(t_date,check_num,description,amount,income,expense,net_total)
        VALUES (?,?,?,?,?,?,?)
        ');
        $stmt->execute([$created_at,$check,$description,$amount,$result['income'],$result['expenses'],$result['net_total']]);
    }
    public function List(): array
    {
        $stmt=$this->db->prepare('
                SELECT * FROM Transactions;
        ');

        $stmt->execute();
        return $stmt->fetchAll();

    }


}