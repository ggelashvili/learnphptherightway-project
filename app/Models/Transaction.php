<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use App\Exceptions\MimeTypeNotAllowedException;

class Transaction extends Model
{
    public function import(): void
    {
        $filePath = $_FILES['transaction']['tmp_name'];

        if ($_FILES['transaction']['type'] !== 'text/csv') {
            throw new MimeTypeNotAllowedException();
        }

        $fh = fopen($filePath, 'r');
        $headers = $row = fgetcsv($fh);
        $count = 0;
        $recordCount = 0;
        $columns = ['created_on', 'check_number', 'description', 'amount'];
        $baseQuery = 'INSERT INTO transactions(' . implode(',', $columns) . ') VALUES';

        while (($row = fgetcsv($fh)) !== false) {
            if ($count === 0) {
                $query = $baseQuery;
            }

            $row[0] = date('Y-m-d', strtotime($row[0]));
            $row[1] = $row[1] ?: null;
            $row[3] = (double) str_replace('$', '', $row[3]);
            $boundedParamNames = [];
            foreach ($columns as $index => $column) {
                $boundedParamName = ":{$column}_{$recordCount}";
                $boundedParamNames[] = $boundedParamName;
                $boundedParams[$boundedParamName] = $row[$index];
            }

            if ($count > 0) {
                $query .= ',';
            }

            $query .= '(' . implode(',', $boundedParamNames)  . ')';
            $count++;
            $recordCount++;

            // To insert 100 records at a time
            if ($count < 100) {
                continue;
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute($boundedParams);
            $count = 0;
        }

        if ($count > 0) {
            $stmt = $this->db->prepare($query);
            $stmt->execute($boundedParams);
        }
    }

    public function findAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM transactions');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
