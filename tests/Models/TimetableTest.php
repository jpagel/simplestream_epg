<?php
namespace Tests\Models;

use App\Models\Programme;
use App\Models\Timetable;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class TimetableTest extends TestCase
{
    use HasFactory;
    /**
     * @test
     */
    public function it_can_calculate_following_start_time()
    {
        $programmeInstance = Programme::factory()->make([
            'visible_name' => 'Test Show',
            'description' => 'There is nothing like this show anywhere else on TV',
            'thumbnail_ref' => 'test_ref',
            'duration' => 3600
        ]);
        $timetableInstance = Timetable::factory()->make([
            'start_time' => new CarbonImmutable('2020-08-01 12:00:00'),
            'channel_id' => 1,
        ]);
        $timetableInstance->setRelation('programme', $programmeInstance);
        $expectedFollowingStartTime = new \DateTimeImmutable('2020-08-01 13:00:00');
        $this->assertEquals($expectedFollowingStartTime, $timetableInstance->calculateFollowingStartTime());
    }
}
