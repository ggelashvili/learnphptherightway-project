<?php

declare(strict_types=1);

namespace App\Services;

class CSVHelper
{
    public function scanFileByPath(string $filePath): array
    {
        $csvData = $this->csvInArray($filePath, ';', '"', false);

        return $this->parseData($csvData);
    }

    protected function csvInArray($url, $delm = ';', $encl = '"', $head = false)
    {
        $csvxrow = file($url);   // ---- csv rows to array ----

        $csvxrow[0] = chop($csvxrow[0]);
        $csvxrow[0] = str_replace($encl, '', $csvxrow[0]);
        $keydata = explode($delm, $csvxrow[0]);
        $keynumb = count($keydata);

        if (true === $head) {
            $anzdata = count($csvxrow);
            $z = 0;
            for ($x = 1; $x < $anzdata; ++$x) {
                $csvxrow[$x] = chop($csvxrow[$x]);
                $csvxrow[$x] = str_replace($encl, '', $csvxrow[$x]);
                $csv_data[$x] = explode($delm, $csvxrow[$x]);
                $i = 0;
                foreach ($keydata as $key) {
                    $out[$z][$key] = $csv_data[$x][$i];
                    ++$i;
                }
                ++$z;
            }
        } else {
            $i = 0;
            foreach ($csvxrow as $item) {
                $item = chop($item);
                $item = str_replace($encl, '', $item);
                $csv_data = explode($delm, $item);
                for ($y = 0; $y < $keynumb; ++$y) {
                    $out[$i][$y] = $csv_data[$y];
                }
                ++$i;
            }
        }

        return $out;
    }

    protected function parseData(array $csvData): array
    {
        $commonHelper = new CommonHelper();
        $resultData = [];
        if (count($csvData) > 1) {
            unset($csvData[0]);
            $csvData = array_values($csvData);

            foreach ($csvData as $val) {
                $array = explode(',', $val[0]);
                $data['date'] = $commonHelper->dateFormat($array[0]);
                $data['check'] = $array[1];
                $data['description'] = $array[2];
                $data['amount'] = str_replace('$', '', $array[3]);
                $resultData[] = $data;
            }
        }

        return $resultData;
    }
}
