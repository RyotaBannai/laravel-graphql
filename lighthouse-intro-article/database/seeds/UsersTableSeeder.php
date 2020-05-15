<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $userDB = DB::table('users');
        Schema::disableForeignKeyConstraints();
        $userDB->truncate();
        Schema::enableForeignKeyConstraints();
        factory(User::class, 10)->create();
    }
}
