<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Kévin POLEYA",
            'email' => "poleya.kevin@gmail.com",
            'password' => Hash::make('azerty$123'),
        ]);
    }
}
