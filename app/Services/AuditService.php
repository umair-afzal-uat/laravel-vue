<?php

namespace App\Services;

use App\Http\Resources\UserActionResource;
use App\Http\Resources\SystemEventResource;
use App\Repositories\AuditRepository;

class AuditService
{
    protected $auditRepository;

    /**
     * AuditService constructor.
     *
     * @param AuditRepository $auditRepository
     */
    public function __construct(AuditRepository $auditRepository)
    {
        $this->auditRepository = $auditRepository;
    }

    /**
     * Get user actions with optional filtering.
     *
     * @param array $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUserActions(array $filters)
    {
        $userActions = $this->auditRepository->getUserActions($filters);
        return UserActionResource::collection($userActions);
    }

    /**
     * Store a new user action.
     *
     * @param array $data
     * @return UserActionResource
     */
    public function storeUserAction(array $data)
    {
        $userAction = $this->auditRepository->storeUserAction($data);
        return new UserActionResource($userAction);
    }

    /**
     * Get system events with optional filtering.
     *
     * @param array $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getSystemEvents(array $filters)
    {
        $systemEvents = $this->auditRepository->getSystemEvents($filters);
        return SystemEventResource::collection($systemEvents);
    }

    /**
     * Store a new system event.
     *
     * @param array $data
     * @return SystemEventResource
     */
    public function storeSystemEvent(array $data)
    {
        $systemEvent = $this->auditRepository->storeSystemEvent($data);
        return new SystemEventResource($systemEvent);
    }
}
