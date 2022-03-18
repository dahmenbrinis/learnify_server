<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->create_levels();
        $user = User::create([
            'name' => 'dahmen',
            'email' => 'dahmen@gmail.com',
            'password' => bcrypt('password'),
            'type' => 0,
        ]);
        $user->profileImage()->create(['user_id' => $user->id, 'src' => 'profile1.png']);
//        $user->createToken('tokens');
        User::factory(40)->create()->each(
            function ($user) {
//                if ($user->id < 12)
                return $user->profileImage()->create(['user_id' => $user->id, 'src' => 'profile' . array_rand([1, 2, 3, 4, 5]) . '.png']);
            }
        );
        $seeder = new RoomSeeder();
        $seeder->run();

        (new QuestionSeeder())->run();
        (new CommentSeeder())->run();
        $user->rooms()->first()->comments;
    }

    private function create_levels()
    {
        Level::create(['name'=>'Primary']);
        Level::create(['name'=>'Secondary']);
        Level::create(['name'=>'University']);
        Level::create(['name'=>'Professional']);
    }
}
