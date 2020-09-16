<?php
namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Programme;
use App\Models\Timetable;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ApiFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->writeFixture();
    }

    protected function writeFixture()
    {
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * @test
     */
    public function channels()
    {
        $response = $this->get('/api/channels');
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                ['id', 'uuid', 'visible_name', 'icon_ref']
            ]
        ]);
        $response->assertJson([
            'data' => [
                ['visible_name' => 'Channel One'],
                ['visible_name' => 'Channel Two']
            ]
        ]);
    }

    /**
     * @test
     */
    public function programme_detail()
    {
        $testItem = Timetable::first();
        $channel = $testItem->channel;
        $programme = $testItem->programme;
        $programme = $testItem->programme;
        $response = $this->get(sprintf('/api/channels/%s/programmes/%s', $channel->uuid, $programme->uuid));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id', 'uuid', 'visible_name', 'description', 'duration'
            ]
        ]);
        $response->assertJsonFragment([
            'uuid' => $programme->uuid,
            'visible_name' => $programme->visible_name
        ]);
    }

    /**
     * @test
     */
    public function channel_listing()
    {
        $channel = Channel::first();
        $timezone = '+0';
        $response = $this->get(sprintf('/api/channels/%s/%s/%s', $channel->uuid, '2020-03-09', $timezone));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                ['id', 'uuid', 'start_time', 'channel_id', 'programme_id', 'visible_name', 'description', 'thumbnail_ref']
            ]
        ]);
        $programmeInstance = Programme::first();
        $response->assertJsonFragment([
            'uuid' => $programmeInstance->uuid,
            'visible_name' => $programmeInstance->visible_name,
            'description' => $programmeInstance->description
        ]);
    }
}
