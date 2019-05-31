<?php

use Illuminate\Database\Seeder;
use Illuminate\App\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i < 5; $i++)
        {
            Article::create(
                [
                    'title' => $faker->sentence,
                    'body' => $faker->paragraph,
                ]
            );
        }
    }
}
