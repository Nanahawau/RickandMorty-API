<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//
//        if (env('environment') === 'production') {
//
//            exit();
//        }
//
//        Eloquent::unguard;
//
//        $tables = [
//            'comments'
//        ];
//
//        Foreach ($tables as $table) {
//            DB::table($table)->truncate();
//        }

        $this->call(CommentTableSeed::class);
    }
}
