<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserAction;
use App\Models\SystemEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuditApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a test user to authenticate the requests
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api'); // Use 'api' if JWT authentication is being used
    }

    /** @test */
    public function it_can_store_user_action()
    {
        $data = [
            'user_id' => $this->user->id,
            'action_type' => 'login',
            'description' => 'User logged in',
            'ip_address' => '127.0.0.1',
        ];

        $response = $this->postJson(route('audit.storeUserAction'), $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'action_type',
                    'description',
                    'ip_address',
                    'performed_at',
                ],
            ]);
        
        $this->assertDatabaseHas('user_actions', [
            'user_id' => $this->user->id,
            'action_type' => 'login',
            'description' => 'User logged in',
        ]);
    }

    /** @test */
    public function it_can_get_user_actions()
    {
        // Seed some user actions
        UserAction::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson(route('audit.getUserActions'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'action_type',
                        'description',
                        'ip_address',
                        'performed_at',
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_store_system_event()
    {
        $data = [
            'event_type' => 'database_update',
            'event_description' => 'Database schema updated',
            'event_data' => ['table' => 'users', 'action' => 'alter'],
        ];

        $response = $this->postJson(route('audit.storeSystemEvent'), $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'event_type',
                    'event_description',
                    'event_data',
                    'occurred_at',
                ],
            ]);
        
        $this->assertDatabaseHas('system_events', [
            'event_type' => 'database_update',
            'event_description' => 'Database schema updated',
        ]);
    }

    /** @test */
    public function it_can_get_system_events()
    {
        // Seed some system events
        SystemEvent::factory()->count(3)->create();

        $response = $this->getJson(route('audit.getSystemEvents'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'event_type',
                        'event_description',
                        'event_data',
                        'occurred_at',
                    ],
                ],
            ]);
    }
}
