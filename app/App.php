<?php

declare(strict_types = 1);

// Your Code

function read_csv_file($filepath) {
    if (is_file($filepath))
        {
            $handle = fopen($filepath, "r");
            $fieldnames = fgetcsv($handle);
            $data = [];
            while(($d = fgetcsv($handle)) !== false)
            {
                $buffer = [];
                for ($i = 0, $x = count($fieldnames); $i < $x; $i++)
                {
                    $buffer[$fieldnames[$i]] = $d[$i]; 
                }
                array_push($data, $buffer);
            }
        return $data;
        }
    else
    {
        return null;
    }
}

function read_csv_files($dirpath)
{
    if (is_dir($dirpath))
    {
        $files = array_diff(scandir($dirpath), array(".", ".."));
        $data_files = [];
        foreach ($files as $filename) 
        {
            $filepath = $dirpath . $filename;
            array_push($data_files, read_csv_file($filepath));
        }
        return $data_files;
    }
    else
    {
        return null;
    }
}