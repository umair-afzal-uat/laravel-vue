<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuditApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $auditServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the AuditService to isolate controller tests
        $this->auditServiceMock = \Mockery::mock(AuditService::class);
        $this->app->instance(AuditService::class, $this->auditServiceMock);
    }

    /** @test */
    public function it_can_fetch_user_actions()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Mocking the service response for user actions
        $this->auditServiceMock
            ->shouldReceive('getUserActions')
            ->once()
            ->andReturn(['action' => 'test action']);

        $response = $this->getJson(route('audit.getUserActions'));

        // Asserting response
        $response->assertStatus(200);
        $response->assertJson([
            'action' => 'test action'
        ]);
    }

    /** @test */
    public function it_can_store_user_action()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Mocking the service response for storing user action
        $this->auditServiceMock
            ->shouldReceive('storeUserAction')
            ->once()
            ->andReturn([
                'user_id' => $user->id,
                'action_type' => 'test action type',
                'description' => 'test action description',
                'ip_address' => '127.0.0.1',
            ]);

        // Posting data with all required fields
        $response = $this->postJson(route('audit.storeUserAction'), [
            'user_id' => $user->id, // Required user ID
            'action_type' => 'test action type', // Action type
            'description' => 'test action description', // Action description
            'ip_address' => '127.0.0.1', // IP address
        ]);

        // Asserting the response status and data
        $response->assertStatus(201);
        $response->assertJson([
            'user_id' => $user->id,
            'action_type' => 'test action type',
            'description' => 'test action description',
            'ip_address' => '127.0.0.1',
        ]);
    }

    /** @test */
    public function it_can_fetch_system_events()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Mocking the service response for system events
        $this->auditServiceMock
            ->shouldReceive('getSystemEvents')
            ->once()
            ->andReturn(['event' => 'test event']);

        $response = $this->getJson(route('audit.getSystemEvents'));

        // Asserting response
        $response->assertStatus(200);
        $response->assertJson([
            'event' => 'test event'
        ]);
    }

    /** @test */
    public function it_can_store_system_event()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Mocking the service response for storing system event
        $this->auditServiceMock
            ->shouldReceive('storeSystemEvent')
            ->once()
            ->andReturn([
                'event_type' => 'test event type',
                'event_description' => 'test event description',
                'ip_address' => '127.0.0.1',
            ]);

        // Posting data with all required fields
        $response = $this->postJson(route('audit.storeSystemEvent'), [
            'event_type' => 'test event type', // Required event type
            'event_description' => 'test event description', // Event description
            'ip_address' => '127.0.0.1', // IP address
        ]);

        // Asserting the response status and data
        $response->assertStatus(201);
        $response->assertJson([
            'event_type' => 'test event type',
            'event_description' => 'test event description',
            'ip_address' => '127.0.0.1',
        ]);
    }
}
