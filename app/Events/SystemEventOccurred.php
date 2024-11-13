<?php
namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemEventOccurred
{
    use Dispatchable, SerializesModels;

    public $eventType;
    public $eventDescription;
    public $eventData;

    public function __construct(string $eventType, string $eventDescription, array $eventData = [])
    {
        $this->eventType = $eventType;
        $this->eventDescription = $eventDescription;
        $this->eventData = $eventData;
    }
}
