<?php
namespace App\Repositories;

use App\Models\UserAction;
use App\Models\SystemEvent;

class AuditRepository
{
    // Get filtered user actions
    public function getUserActions(array $filters)
    {
        $query = UserAction::query();

        // Apply filters
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->latest()->paginate(10);
    }

    // Store new user action
    public function storeUserAction(array $data)
    {
        return UserAction::create($data);
    }

    // Get filtered system events
    public function getSystemEvents(array $filters)
    {
        $query = SystemEvent::query();

        // Apply filters
        if (!empty($filters['event_type'])) {
            $query->where('event_type', $filters['event_type']);
        }

        return $query->latest()->paginate(10);
    }

    // Store new system event
    public function storeSystemEvent(array $data)
    {
        return SystemEvent::create($data);
    }
}