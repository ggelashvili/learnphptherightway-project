<?php

declare(strict_types = 1);

namespace App\Models;

use App\Enums\InvoiceStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int           $id
 * @property string        $invoice_number
 * @property float         $amount
 * @property InvoiceStatus $status
 * @property Carbon        $created_at
 * @property Carbon        $due_date
 *
 * @property-read Collection $items
 */
class Invoice extends Model
{
    const UPDATED_AT = null;

    protected $casts = [
        'created_at' => 'datetime',
        'due_date'   => 'datetime',
        'status'     => InvoiceStatus::class,
    ];

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
