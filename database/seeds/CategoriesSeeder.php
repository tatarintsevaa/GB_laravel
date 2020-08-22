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
                    'slug' => 'Politics',
                ],
                [
                    'name' => 'Спорт',
                    'slug' => 'Sport',
                ],
                [
                    'name' => 'Наука',
                    'slug' => 'Science',
                ],
                [
                    'name' => 'Экономика',
                    'slug' => 'Economic',
                ]
            ]
        );
    }
}
