<?php

use App\Level;
use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'name' => Level::LEVEL_SIXTH,
        ]);

        Level::create([
            'name' => Level::LEVEL_FIFTH,
        ]);

        Level::create([
            'name' => Level::LEVEL_FOURTH,
        ]);

        Level::create([
            'name' => Level::LEVEL_THIRD,
        ]);

        Level::create([
            'name' => Level::LEVEL_SECOND,
        ]);

        Level::create([
            'name' => Level::LEVEL_FIRST,
        ]);

        Level::create([
            'name' => Level::LEVEL_TERMINAL,
        ]);
    }
}
