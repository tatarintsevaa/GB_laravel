<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category
{
    private static $categories = [
        1 => [
            'id' => 1,
            'name' => 'Политика',
            'slug' => 'politic'
        ],
        2 => [
            'id' => 2,
            'name' => 'Спорт',
            'slug' => 'sport'
        ],
        3 => [
            'id' => 3,
            'name' => 'Наука',
            'slug' => 'science'
        ],
    ];

    public static function getCategories() {
        return static::$categories;
    }

    public static function getCategoryIdByName(string $name) {
        $category_id = null;
        foreach (static::$categories as $item) {
            if ($item['slug'] == $name) {
                $category_id = $item['id'] ;
            }
        }
        return $category_id;
    }
}
