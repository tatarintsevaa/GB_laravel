<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            [
                [
                    'name' => 'Политика',
                    'slug' => 'politic',
                ],
                [
                    'name' => 'Спорт',
                    'slug' => 'sport',
                ],
                [
                    'name' => 'Наука',
                    'slug' => 'science',
                ],
                [
                    'name' => 'Экономика',
                    'slug' => 'economic',
                ]
            ]
        );
    }
}
