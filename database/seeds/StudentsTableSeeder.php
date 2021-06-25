<?php

use App\Level;
use App\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = new Student([
            'name' => "DUPONT",
            'firstname' => "Jean",
            'email' => "dupont.jean@gmail.com",
            'is_active' => true,
        ]);
        $student->level()->associate(Level::LEVEL_TERMINAL_ID)->save();

        $student = new Student([
            'name' => "LUPIN",
            'firstname' => "Jack",
            'email' => "lupin.jack@gmail.com",
        ]);
        $student->level()->associate(Level::LEVEL_SECOND_ID)->save();
    }
}
