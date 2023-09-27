<?php

declare(strict_types=1);

namespace app\PaymentGateway\Paddle;
use App\Enums\Status;

class Transaction
{
    private string $status;
    public function __construct()
    {
        $this->setStatus(Status::PENDING);
    }

    public function setStatus($status): self
    {
        if (!isset(Status::ALL_STATUSES[$status])) {
            throw new \InvalidArgumentException('Status not exists');
        }
        $this->status = $status;

        return $this;
    }
}
