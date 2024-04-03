<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Models\User;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChirpCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // Constructor method
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        // This method handles the ChirpCreated event.
        // It sends notifications about the new chirp to all users except the one who created the chirp.

        // Retrieve all users except the one who created the chirp and iterate through them.
        foreach (User::whereNot('id', $event->chirp->user_id)->cursor() as $user) {
            // Notify each user about the new chirp by sending them a NewChirp notification.
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
