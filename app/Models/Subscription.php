<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_id',
        'transaction_id',
        'started_at',
        'active_until',
        'is_active',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'active_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationship: Subscription belongs to Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relationship: Subscription belongs to Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Relationship: Subscription belongs to Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Helper method: Check if subscription is still active
    public function isActive()
    {
        return $this->is_active && $this->active_until > now();
    }
}
