<?php

use Illuminate\Database\Seeder;

class CommentTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $faker = Faker\Factory::create();

        for($i = 0; $i < 100; $i++){



            \App\Comment::create([
                'episode_id' => $faker->numberBetween(1, 31),
                'comment' => $faker->realText('200', '3')
            ]);
        }

        }






}
