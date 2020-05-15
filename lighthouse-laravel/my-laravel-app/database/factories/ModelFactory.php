<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Image;
use \App\Models\Group;
use App\Models\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $name_list = [
        'Sophia', 'Isabella', 'Emma', 'Olivia', 'Ava', 'Emily', 'Abigail', 'Madison', 'Mia', 'Chloe',
        'Jacob', 'Mason', 'William', 'Jayden', 'Noah', 'Michael','Ethan', 'Alexander', 'Aiden', 'Daniel'
    ];
    return [
        'name' => $faker->randomElement($name_list), // $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => function() use ($faker){
            if($faker->boolean(70)) return $faker->dateTime;
        },
        // 'email'=> str_random(10), '@gmail.com', str_random is duplicated
        'password' => Hash::make($faker->password), // bcrypt('secret'),
        'remember_token' => '',
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime, // new DateTime()
        'active' => $faker->boolean // array_rand(array(0,1))
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
            },
        'title' => $faker->realText(20),
        'content' => $faker->sentence(50),
        'category' => $faker->randomElement(['World', 'U.S.', 'Politics', 'Business', 'Opinion', 'Sports']),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => function() use ($faker){
            if($faker->boolean(10)) return $faker->dateTime;
            },
    ];
});

$factory->define(Comment::class, function (Faker $faker) {
    $bool = $faker->boolean();
    return [
        'target_id' => function () use ($faker, $bool) {
            if ($bool) {
                return factory(Post::class)->create()->id;
            }
            else {
                return factory(Comment::class)->create()->id;
            }
        },
        'target_type' => function () use ($faker, $bool) {
            if ($bool) {
                return 'App\Models\Post';
            }
            else {
                return 'App\Models\Comment';
            }
        },
        'reply' => $faker->realText(20),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => function() use ($faker){
            if($faker->boolean(10)) return $faker->dateTime;
        },
    ];
});

$factory->define(Image::class, function (Faker $faker) {
    $bool = $faker->boolean();
    return [
        'target_id' => function () use ($faker, $bool) {
            if ($bool) {
                return factory(Post::class)->create()->id;
            }
            else {
                return factory(Comment::class)->create()->id;
            }
        },
        'target_type' => function () use ($faker, $bool) {
            if ($bool) {
                return 'App\Models\Post';
            }
            else {
                return 'App\Models\Comment';
            }
        },
        'filename' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});

//$factory->defineAs(User::class, 'in_active', function ($faker) use ($factory) {
//    $users = $factory->raw(User::class);
//    return array_merge($users, ['active' => 0]);
//});

$factory->define(Group::class, function () { return []; });
$factory->state(Group::class, 'with_rand_timestamp', function (Faker $faker) {
    return [
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
