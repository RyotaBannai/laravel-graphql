<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\UserGroup;
use App\Models\User;

class UserGroupTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $userGroupDB = DB::table('user_group');
        $userGroupDB->truncate();
        User::all()->each(function($user, $key) use($faker) {
            UserGroup::create([
                'user_id' => $user->id,
                'group_id' => $faker->randomElement([1,2,3,4]),
                'role_id' => $faker->randomElement([1,2,3,4]),
                'updated_at' => $faker->dateTime
            ]);
        });
    }
}
