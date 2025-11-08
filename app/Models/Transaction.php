<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_id',
        'amount',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'payment_method',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    // Relationship: Transaction belongs to Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relationship: Transaction belongs to Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Relationship: Transaction has one Subscription
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    // Helper method: Check if transaction is successful
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    // Helper method: Check if transaction is expired
    public function isExpired()
    {
        return $this->expired_at && $this->expired_at < now();
    }
}
