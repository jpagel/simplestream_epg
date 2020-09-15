<?php

namespace Database\Factories;

use App\Models\Programme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgrammeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Programme::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => bin2hex(random_bytes(16)),
            'visible_name' => 'Test Show',
            'description' => 'There is nothing like this show anywhere else on TV',
            'thumbnail_ref' => 'test_ref',
            'duration' => 3600
        ];
    }
}