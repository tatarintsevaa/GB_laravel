<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('news')->insert($this->getData());
        factory(News::class, 100)->create();
    }



}
