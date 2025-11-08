<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'password',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationship: Member has many Subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Relationship: Member has many Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Helper method: Get active subscription
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('active_until', '>', now())
            ->where('is_active', true)
            ->first();
    }
}
