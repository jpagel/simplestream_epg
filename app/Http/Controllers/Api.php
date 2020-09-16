<?php

namespace App\Http\Controllers;

use App\Http\Resources\Channel as ChannelResource;
use App\Http\Resources\Programme as ProgrammeResource;
use App\Http\Resources\ProgrammeCollectionResource;
use App\Models\Channel;
use App\Models\Programme;
use App\Models\Timetable;

class Api
{
    public function channels()
    {
        return new ChannelResource(Channel::all());
    }

    public function programmeInformation(string $channelUuid, string $programmeUuid)
    {
        return new ProgrammeResource(Programme::getByUuid($programmeUuid));
    }

    public function programmesByChannel(string $channelUuid, string $date, string $timezone)
    {
        $channel = Channel::getByUuid($channelUuid, $date);
        return new ProgrammeCollectionResource(Timetable::getProgrammesByChannelIdAndDateAndTimezone($channel->id, $date, $timezone));
    }
}
