<?php

use App\User;
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
        $user = new User([
            'name' => "Kévin POLEYA",
            'email' => "poleya.kevin@gmail.com",
            'password' => Hash::make('azerty$123'),
        ]);
        $user->assignRole('administrator')->save();
    }
}
