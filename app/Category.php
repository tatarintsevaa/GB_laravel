<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;

class Category
{
//    private static $categories = [
//        '1' => [
//            'id' => 1,
//            'name' => 'Политика',
//            'slug' => 'politic'
//        ],
//        '2' => [
//            'id' => 2,
//            'name' => 'Спорт',
//            'slug' => 'sport'
//        ],
//        '3' => [
//            'id' => 3,
//            'name' => 'Наука',
//            'slug' => 'science'
//        ],
//    ];

    public static function getCategories() {
        return json_decode(\Storage::get('public/categories.json'), true);
    }

    public static function getOneCategory(string $id) {
        return static::getCategories()[$id];
    }

    public static function getCategoryIdByName(string $name) {
        $category_id = null;
        foreach (static::getCategories() as $item) {
            if ($item['slug'] == $name) {
                $category_id = $item['id'] ;
            }
        }
        return $category_id;
    }


}
