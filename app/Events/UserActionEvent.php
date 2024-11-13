<?php
namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActionEvent
{
    use Dispatchable, SerializesModels;

    public $user;
    public $actionType;
    public $description;
    public $ipAddress;

    public function __construct(User $user, string $actionType, string $description, string $ipAddress)
    {
        $this->user = $user;
        $this->actionType = $actionType;
        $this->description = $description;
        $this->ipAddress = $ipAddress;
    }
}
