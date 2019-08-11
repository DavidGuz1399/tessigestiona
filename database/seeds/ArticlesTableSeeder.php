<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'category_id'=>1,
            'registry_number'=>"15463",
            'name'=>'Teclado',
            'quantity'=>12345
        ]);
    }
}
