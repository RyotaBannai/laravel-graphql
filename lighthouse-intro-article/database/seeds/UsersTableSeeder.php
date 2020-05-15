<?php

use Illuminate\Database\Seeder;
use App\User;
use \App\Models\Article;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $userDB = DB::table('users');
        $articleDB = DB::table('articles');
        // Schema::disableForeignKeyConstraints();
        $userDB->truncate();
        $articleDB->truncate();
        // Schema::enableForeignKeyConstraints();
        factory(User::class, 10)
            ->create()
            ->map(function($user){ // each だと戻らないため
                return $user->articles()->saveMany(factory('\App\Models\Article', 2)->create([
                    'user_id' => $user->id, // overwrite default setting
                ]));
            });
    }
}
