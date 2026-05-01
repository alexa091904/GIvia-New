<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount',
        'max_uses', 'used_count', 'expires_at', 'is_active'
    ];

    protected $casts = [
        'expires_at'      => 'datetime',
        'is_active'       => 'boolean',
        'min_order_amount'=> 'decimal:2',
        'value'           => 'decimal:2',
    ];

    /**
     * Check if the coupon is currently valid.
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for a given subtotal.
     * Returns 0 if minimum order amount is not met.
     */
    public function applyDiscount(float $subtotal): float
    {
        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'percent') {
            return round($subtotal * ($this->value / 100), 2);
        }

        // Fixed discount — cannot exceed the subtotal
        return min((float) $this->value, $subtotal);
    }

    /**
     * Increment used_count when a coupon is consumed.
     */
    public function markUsed(): void
    {
        $this->increment('used_count');
    }
}
