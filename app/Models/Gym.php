<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    /** @use HasFactory<\Database\Factories\GymFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'user_id',
        'name',
        'description',
        'address',
        'city',
        'phone',
        'image',
    ];

    // Relationship: Gym has many Plans
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    // Relationship: Gym belongs to User (gym owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: Gym has many Subscriptions through Plans
    public function subscriptions()
    {
        return $this->hasManyThrough(Subscription::class, Plan::class);
    }
}
