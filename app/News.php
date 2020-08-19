<?php

namespace App;


class News
{

    public static function getNews()
    {
        return json_decode(\Storage::get('public/news.json'), true);
    }

    public static function getOneNews($id) {
        return static::getNews()[$id] ?? null;
    }

    public static function getNewsByCategories($id) {
        $news = [];
        foreach (static::getNews() as $item) {
            if ($id == $item['category_id']) {
               array_push($news,$item);
            }
        }
        return $news;
    }


}
