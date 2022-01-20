<?php

namespace App\Models;

use App\App;
use DateTime;
use http\Exception\RuntimeException;

class Transaction
{

  public function __construct(private DateTime $date, private string $check, private string $description, private float $amount)
  {
  }

  public static function create(string $date, string $check, string $description, string $amount)
  {
    $db = App::db();
    $insert = $db->prepare("INSERT INTO transactions (date, check_number, description, amount) values (?, ?, ?, ?)");
    $insert->execute([$date, $check, $description, $amount]);
  }

  /**
   * @return Transaction[]
   */
  public static function getAll(): array
  {
    $db = App::db();
    $statement = $db->query("select * from transactions");
    $res = [];
    foreach ($statement->fetchAll() as $row) {
      $date = DateTime::createFromFormat('Y-m-d', $row['date']);
      if ($date === false) {
        throw new RuntimeException("");
      }
      $res[] = new Transaction($date, $row['check_number'], $row['description'], (float)$row['amount']);
    }
    return $res;
  }

  public function getDate(): DateTime
  {
    return $this->date;
  }

  public function getCheck(): string
  {
    return $this->check;
  }

  public function getDescription(): string
  {
    return $this->description;
  }

  public function getAmount(): float
  {
    return $this->amount;
  }

  public static function getFormattedAmount($amount): string
  {
    $sign = $amount >= 0 ? "" : "-";
    $abs_amount = abs($amount);
    return "$sign\$$abs_amount";
  }

}