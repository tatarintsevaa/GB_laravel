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

    private function getData(): array
    {
        $data = [];
        $faker = Faker\Factory::create('ru_RU');
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'title' => $faker->realText(rand(10, 30)),
                'text' => $faker->realText(rand(1000, 3000)),
                'isPrivate' => (bool)rand(0,1),
                'category_id' => (int)rand(1, 4)
            ];
        }
        return $data;
    }
}
