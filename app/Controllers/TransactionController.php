<?php
declare(strict_types = 1);

namespace App\Controllers;
use App\View;
use App\Models\Transaction;
class TransactionController {

    protected $transModel;

    public function __construct() {
        $this->transModel = new Transaction();
    }
    
    public function index() {
        $transactions = $this->transModel->getAll();
        $totals = $this->transModel->calculateTotals($transactions);
        return View::make('transactions', ['transactions' => $transactions,'totals' => $totals])->render();
    }

    public function store() {
        $csvFile = $_FILES['transactions']['tmp_name'];
        if(! file_exists($csvFile)) {
            throw new \Exception('file not found');
        }

        $this->transModel->create($csvFile);

        header('location: /transactions');
    }
}