<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\Programme;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DateTimeImmutable;

class Timetable extends Model
{
    use HasFactory, DatabaseMigrations;

    public $table = 'timetable';

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'start_time',
        'channel_id',
        'programme_id'
    ];

    public function programme(): hasOne
    {
        return $this->hasOne(Programme::class, 'id', 'programme_id');
    }

    public function channel(): hasOne
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }

    public function calculateFollowingStartTime(): DateTimeImmutable
    {
        return (new CarbonImmutable($this->start_time))
            ->addSeconds($this->programme->duration)
            ->toDateTimeImmutable();
    }

    public static function findProgrammesByChannelId(int $channelId): Builder
    {
        return self::where([
            'channel_id' => $channelId
        ])
            ->join('programme', 'programme.id', '=', 'timetable.programme_id');
    }

    public static function getProgrammesByChannelIdAndDate(int $channelId, DateTimeImmutable $date): Builder
    {
        $startTime = $date;
        $endTime = (new CarbonImmutable($date))->add('day', 1);
        return self::findProgrammesByChannelId($channelId)
            ->where([
                ['start_time', '>=', $startTime],
                ['start_time', '<', $endTime]
            ]);
    }

    public static function getProgrammesByChannelIdAndDateAndTimezone(int $channelId, string $date, string $timezone): Collection
    {
        $startTime = CarbonImmutable::createFromFormat('Y-m-d H:i:s', sprintf('%s 00:00:00', $date), str_replace('-', '/', $timezone))
            ->setTimeZone('utc');
        return self::getProgrammesByChannelIdAndDate($channelId, $startTime)
            ->get();
    }
}
