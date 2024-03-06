<?php
declare(strict_types=1);
require_once ('../app/App.php');
require_once ('../views/transactions.php');
global $totalIncome;
global $totalExpense;
global $totalNet;

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('app/App.php', $root . 'app' . DIRECTORY_SEPARATOR);
define('transaction_files/sample_1.csv', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('views/transactions.php', $root . 'views' . DIRECTORY_SEPARATOR);