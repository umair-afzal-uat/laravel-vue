<?php

namespace App\Listeners;

use App\Events\UserActionEvent;
use App\Models\UserAction;

class LogUserActionListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(UserActionEvent $event)
    {
        // Log the user action in the database
        UserAction::create([
            'user_id' => $event->user->id,
            'action_type' => $event->actionType,
            'description' => $event->description,
            'ip_address' => $event->ipAddress,
        ]);
    }
}
