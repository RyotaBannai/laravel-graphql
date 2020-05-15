<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Image;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $userDB = DB::table('users');
        $postDB = DB::table('posts');
        $imageDB = DB::table('images');
        $commentDB = DB::table('comments');
        $userDB->truncate(); // or use model like this: User::truncate();
        // $userDB->delete(); // doesn't reset auto increment counter.. so use truncate.
        $postDB->truncate();
        $imageDB->truncate();
        $commentDB->truncate();

        // $users = factory(User::class, 10)->create();
        $users_posts = factory(User::class, 10)
            ->create()
            ->map(function($user){ // each だと戻らないため
                return $user->posts()->saveMany(factory(Post::class, 2)->create([
                    'user_id' => $user->id, // overwrite default setting
               ]));
            })->flatten(); // 1ユーザーに対し複数のpostインタンスを生成してるためcollectionになるため

        $users_posts->each(function($post){
        // $post->images()->save(factory(Image::class)->make([
            $post->images()->saveMany(
                factory(Image::class, Arr::random([1, 2, 3]))->make([
                    'target_id' => $post->id,
                    'target_type' => 'App\Models\Post',
                ]));

            $post->comments()->saveMany(
                factory(Comment::class, Arr::random([2]))->create([
                    'target_id' => $post->id,
                    ])
                    ->each(function ($comment){
                        $comment->images()->saveMany(factory(Image::class, Arr::random([1, 2]))->make([
                            'target_id' => $comment->id,
                            'target_type' => 'App\Models\Comment',
                        ]));
                    })
                    ->each(function ($comment){
                        $comment->comments()->saveMany(factory(Comment::class, Arr::random([1, 2]))->create([
                            'target_id' => $comment->id,
                            'target_type' => 'App\Models\Comment',
                        ])->flatten()->each(function($comment){
                            $comment->images()->saveMany(factory(Image::class, Arr::random([1, 2]))->make([
                                'target_id' => $comment->id,
                                'target_type' => 'App\Models\Comment',
                            ]));
                        }));
                    })
            );
        });
    }
}
        // use factory instead of seed file.
//        $faker = Faker\Factory::create();
//        for($i=0, $end=10; $i < $end; ++$i) {
//            $userDB->insert([
//                'name' => $faker->userName
//            ]);
//        }
