<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
 
        foreach (range(1,20) as $index) {
 
            $post = new \App\Posts();
 
            $post->title = $faker->word;
 
            $post->body = $faker->paragraph;
 
            $post->photo = 'Laptop.jpg';
 
            $post->save();
        }
    }
}
