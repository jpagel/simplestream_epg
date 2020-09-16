<?php
namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Programme;
use App\Models\Timetable;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimetableSeeder extends Seeder
{
    use RefreshDatabase;

    public function run()
    {
        $faker = FakerFactory::create();
        $programmes = Programme::all();
        $channels = Channel::all();
        $programmesPerChannel = intdiv($programmes->count(), $channels->count());
        $startTime = CarbonImmutable::createSafe(2020, 3, 9, 5, 0, 0);
        $mutatingIndex = 0;
        while($slice = $programmes->slice($mutatingIndex, $programmesPerChannel)) {
            if($channel = $channels->shift()) {
                $this->linearAssign($slice, $channel, $startTime, $faker);
            }
            else {
                break;
            }
            $mutatingIndex += $programmesPerChannel;
        }
    }

    protected function linearAssign(Collection $programmes, Channel $channel, DateTimeImmutable $startTime, FakerGenerator $faker): void
    {
        $lastWritten = null;
        foreach($programmes as $programme) {
            $lastWritten = Timetable::factory()->create([
                'uuid' => $faker->uuid,
                'start_time' => ($lastWritten) ? $lastWritten->calculateFollowingStartTime() : $startTime,
                'channel_id' => $channel->id,
                'programme_id' => $programme->id
            ]);
        }
    }
}
