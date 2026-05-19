<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Profile;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Automatically create a profile for the user
        Profile::create([
            'user_id' => $user->id,
            'bio' => '',
            'image_url' => null,
        ]);
    }
}
