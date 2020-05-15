<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $roleDB = DB::table('roles');
        $roleDB->truncate();
        $roles = [
            'Post', 'Delete', 'Update', 'Read'
        ];
        foreach ($roles as $role)
            Role::create([
                'name' => $role,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]);
    }
}
