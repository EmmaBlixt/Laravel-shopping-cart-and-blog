<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User;
        $user->name = "John";
        $user->last_name = "Doe";
        $user->age = 40;
        $user->admin = 1;
        $user->email = "test@mail.se";
        $user->password = Hash::make("password");
        $user->save();


        $user = new User;
        $user->name = "Jane";
        $user->last_name = "Doe";
        $user->age = 20;
        $user->admin = 1;
        $user->email = "testing@mail.se";
        $user->password = Hash::make("password");
        $user->save();

    }
}
