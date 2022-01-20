<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\Transaction;
use App\View;
use DateTime;

class UploadController
{
	public function index(): View
	{
		return View::make("upload");
	}
	
	public function upload(): View
	{
		$file_name = $_FILES['table']['tmp_name'];
		$file = fopen($file_name, 'r');
		
		$rows = [];
		while (($line = fgetcsv($file)) !== false) {
			$rows[] = $line;
		}
		fclose($file);
		array_shift($rows);
		$db = App::db();
		try {
			$db->beginTransaction();
			foreach ($rows as $row) {
				$date = DateTime::createFromFormat('d/m/Y', $row[0]);
				$check = $row[1];
				$description = $row[2];
				$amount = str_replace([',', '$'], '', $row[3]);
				Transaction::create($date->format('Y-m-d'), $check, $description, $amount);
			}
			$db->commit();
		} catch (\PDOException $exception) {
			if ($db->inTransaction()) {
				$db->rollBack();
			}
			throw $exception;
		}
		return new View('success');
	}
}