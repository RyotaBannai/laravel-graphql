<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         $this->call(UsersTableSeeder::class);
         $this->call(TagsTableSeeder::class);
         $this->call(GroupsTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(UserGroupTableSeeder::class);
    }
}
