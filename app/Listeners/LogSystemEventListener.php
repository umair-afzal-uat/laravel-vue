<?php

namespace App\Listeners;

use App\Events\SystemEventOccurred;
use App\Models\SystemEvent;

class LogSystemEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SystemEventOccurred $event)
    {
        // Log the system event in the database
        SystemEvent::create([
            'event_type' => $event->eventType,
            'event_description' => $event->eventDescription,
            'event_data' => $event->eventData,
        ]);
    }
}
