<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user =  new User([
             'name'=>'dahmen',
             'email'=>'dahmen@gmail.com',
             'password'=>bcrypt('password')
         ]);
        $user->save();
        \App\Models\User::factory(10)->create();
    }
}
