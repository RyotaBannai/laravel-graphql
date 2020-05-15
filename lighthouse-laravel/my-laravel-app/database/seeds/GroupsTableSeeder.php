<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Group;
use Illuminate\Support\Collection;

class GroupsTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $groupDB = DB::table('groups');
        $groupDB->truncate();
        $groups = collect([
            'Developer', 'Admin', 'User', 'Poweruser'
        ]);
//        foreach ($groups as $group)
//            Group::create([
//                'name' => $group,
//                'created_at' => $faker->dateTime,
//                'updated_at' => $faker->dateTime
//            ]);
        $groups->each(function($group){
            factory(Group::class)->state('with_rand_timestamp')->create([
            //factory(Group::class)->create([
                'name' => $group,
            ]);
        });
    }
}
