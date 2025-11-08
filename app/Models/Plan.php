<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'description',
        'price',
        'duration_months',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_months' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relationship: Plan belongs to Gym
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    // Relationship: Plan has many Subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Relationship: Plan has many Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
