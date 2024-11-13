<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserActionRequest;
use App\Http\Requests\StoreSystemEventRequest;
use App\Models\SystemEvent;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuditController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Fetch all user actions.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getUserActions(Request $request): JsonResponse
    {
        $userActions = $this->auditService->getUserActions($request->all());
        return response()->json($userActions);
    }

    /**
     * Store a new user action.
     *
     * @param  StoreUserActionRequest  $request
     * @return JsonResponse
     */
    public function storeUserAction(StoreUserActionRequest $request): JsonResponse
    {
        $userAction = $this->auditService->storeUserAction($request->validated());
        return response()->json($userAction, 201);
    }

    /**
     * Fetch all system events.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getSystemEvents(Request $request): JsonResponse
    {
        $systemEvents = $this->auditService->getSystemEvents($request->all());
        return response()->json($systemEvents);
    }

    /**
     * Store a new system event.
     *
     * @param  StoreSystemEventRequest  $request
     * @return JsonResponse
     */
    public function storeSystemEvent(StoreSystemEventRequest $request): JsonResponse
    {
        $systemEvent = $this->auditService->storeSystemEvent($request->validated());
        return response()->json($systemEvent, 201);
    }


    /**
     * Display a listing of system events.
     */
    public function auditSystemEvents(): JsonResponse
    {
        // Get system events using the service
        $events = $this->auditService->getAuditSystemEvents();

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'data' => $events,
        ], 200);
    }

    /**
     * Display a listing of user actions.
     */
    public function auditUserActions(): JsonResponse
    {
        // Get user actions using the service
        $events = $this->auditService->getAuditUserActions();

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'data' => $events,
        ], 200);
    }
}
