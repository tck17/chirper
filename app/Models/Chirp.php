<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;

    // Enable mass-assignment for message attribute
    protected $fillable = [
        'message',
    ];

    // Define events to dispatch
    protected $dispatchesEvents = [
        'created' => ChirpCreated::class, // Dispatch ChirpCreated event when a chirp is created
    ];

    // Define relationship: a chirp belongs to a user
    public function user(): BelongsTo
    {
        // Define the relationship between Chirp and User models
        // A chirp belongs to a user (i.e., each chirp is associated with a single user)
        return $this->belongsTo(User::class);
    }
}
