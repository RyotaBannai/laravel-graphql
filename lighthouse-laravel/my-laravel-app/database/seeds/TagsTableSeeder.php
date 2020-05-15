<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Generator as Faker;

class TagsTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $tagDB = DB::table('tags');
        $tagDB->truncate();
        $tags = [
            'Report', 'Interview', 'Opinion', 'Thesis',
            'Essay', 'Documentary', 'Autobiography'
        ];
        foreach ($tags as $tag)
            Tag::create([
                'name' => $tag,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]);
    }
}
