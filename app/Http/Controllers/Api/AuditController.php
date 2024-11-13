<?php

namespace App\Http\Controllers\Api;

use App\Events\SystemEventOccurred;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserActionRequest;
use App\Http\Requests\StoreSystemEventRequest;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class AuditController extends Controller
{
    // Service for handling audit-related functionality
    protected $auditService;

    /**
     * Constructor to initialize the AuditService.
     *
     * @param  AuditService  $auditService  The service for handling audit logic.
     */
    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Fetch all user actions.
     *
     * This method retrieves all user actions based on the given request parameters.
     *
     * @param  Request  $request  The incoming HTTP request containing filter parameters.
     * @return JsonResponse  JSON response containing the list of user actions.
     */
    public function getUserActions(Request $request): JsonResponse
    {
        $userActions = $this->auditService->getUserActions($request->all());
        return response()->json($userActions);
    }

    /**
     * Store a new user action.
     *
     * This method stores a new user action in the database after validating the request data.
     *
     * @param  StoreUserActionRequest  $request  The request containing the user action data.
     * @return JsonResponse  JSON response containing the stored user action.
     */
    public function storeUserAction(StoreUserActionRequest $request): JsonResponse
    {
        $userAction = $this->auditService->storeUserAction($request->validated());
        return response()->json($userAction, 201); // Return 201 for successful creation
    }

    /**
     * Fetch all system events.
     *
     * This method retrieves all system events based on the given request parameters.
     *
     * @param  Request  $request  The incoming HTTP request containing filter parameters.
     * @return JsonResponse  JSON response containing the list of system events.
     */
    public function getSystemEvents(Request $request): JsonResponse
    {
        $systemEvents = $this->auditService->getSystemEvents($request->all());
        return response()->json($systemEvents);
    }

    /**
     * Store a new system event.
     *
     * This method stores a new system event in the database after validating the request data.
     *
     * @param  StoreSystemEventRequest  $request  The request containing the system event data.
     * @return JsonResponse  JSON response containing the stored system event.
     */
    public function storeSystemEvent(StoreSystemEventRequest $request): JsonResponse
    {
        $systemEvent = $this->auditService->storeSystemEvent($request->validated());
        return response()->json($systemEvent, 201); // Return 201 for successful creation
    }

    /**
     * Display a listing of system events.
     *
     * This method fetches all audit system events and returns them in a JSON response.
     *
     * @return JsonResponse  JSON response containing the list of system events.
     */
    public function auditSystemEvents(): JsonResponse
    {
        $events = $this->auditService->getAuditSystemEvents();

        return response()->json([
            'status' => 'success',
            'data' => $events,
        ], 200); 
    }

    /**
     * Display a listing of user actions.
     *
     * This method fetches all audit user actions and returns them in a JSON response.
     *
     * @return JsonResponse  JSON response containing the list of user actions.
     */
    public function auditUserActions(): JsonResponse
    {
        $events = $this->auditService->getAuditUserActions();

        return response()->json([
            'status' => 'success',
            'data' => $events,
        ], 200);
    }

    /**
     * Clear the system cache.
     *
     * This method clears the application cache and triggers a system event for cache clearing.
     *
     * @return JsonResponse  JSON response indicating the status of the cache clearing operation.
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            event(new SystemEventOccurred(
                'Cache Flushed', 
                'The system cache was cleared.', 
                ['cache' => 'all'] 
            ));

            return response()->json(['message' => 'Cache cleared successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to clear cache', 'message' => $e->getMessage()], 500);
        }
    }
}

