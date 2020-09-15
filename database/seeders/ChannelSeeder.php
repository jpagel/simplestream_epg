<?php
namespace Database\Seeders;

use App\Models\Channel;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class ChannelSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach([
                    ['uuid' => $faker->uuid, 'visible_name' => 'Channel One', 'icon_ref' => 'channel_one_icon'],
                    ['uuid' => $faker->uuid, 'visible_name' => 'Channel Two', 'icon_ref' => 'channel_two_icon'],
                    ['uuid' => $faker->uuid, 'visible_name' => 'Channel Three', 'icon_ref' => 'channel_three_icon'],
                    ['uuid' => $faker->uuid, 'visible_name' => 'Channel Four', 'icon_ref' => 'channel_four_icon']
                ] as $channelInfo) {
            (new Channel($channelInfo))->save();
        }
    }
}
