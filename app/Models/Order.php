<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = [
        'Confirmed',
        'Preparing',
        'Ready',
        'Completed',
        'Cancelled',
    ];

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'notes',
        'total_amount',
        'order_type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusClassAttribute(): string
    {
        return 'status-' . str($this->status)->lower()->replace(' ', '-');
    }

    public function availableNextStatuses(): array
    {
        return match ($this->status) {
            'Confirmed' => ['Preparing', 'Cancelled'],
            'Preparing' => ['Ready', 'Cancelled'],
            'Ready' => ['Completed', 'Cancelled'],
            default => [],
        };
    }
}
