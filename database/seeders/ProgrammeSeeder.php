<?php
namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Programme;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProgrammeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach([
                    'Alby',
                    'Billie',
                    'Carly',
                    'Dorcas',
                    'Eggbert',
                    'Fazioli',
                    'Goolagong',
                    'Helen',
                    'Inigo',
                    'Jezebel',
                    'Klaatu',
                    'Liskoff',
                    'Marie-clair',
                    'Nobody',
                    'Oona',
                    'Penquartz',
                    'Quirrel',
                    'Rosenberg',
                    'Smiita',
                    'Trelawney',
                    'Ullman',
                    'VanAllen',
                    'William',
                    'Xantippa',
                    'Yerevan',
                    'Zemlinsky'
                ] as $name) {
            (new Programme([
                'uuid' => $faker->uuid,
                'visible_name' => sprintf('The %s Show', $name),
                'description' => sprintf('Another hilarius episode in the life of %s', $name),
                'thumbnail_ref' => sprintf('%s_thumbnail', $name),
                'duration' => mt_rand(1,30) * 5 * 60
            ]))->save();
        }
    }
}
