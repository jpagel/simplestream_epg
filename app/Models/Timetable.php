<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\Programme;
use Carbon\CarbonImmutable;
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
        return $this->hasOne(Programme::class);
    }

    public function channels(): hasOne
    {
        return $this->hasOne(Channel::class);
    }

    public function calculateFollowingStartTime(): DateTimeImmutable
    {
        return (new CarbonImmutable($this->start_time))
            ->addSeconds($this->programme->duration)
            ->toDateTimeImmutable();
    }
}
