<?php

namespace App;


class News
{
    private static $news = [
        1 => [
            'id' => 1,
            'title' => 'Новость №1',
            'text' => 'Текст новости номер 1, бла бла бла',
            'category_id' => 1
        ],
        2 => [
            'id' => 2,
            'title' => 'Новость №2',
            'text' => 'Текст новости номер 2, тра ла ла',
            'category_id' => 2
        ],
        3 => [
            'id' => 3,
            'title' => 'Новость №3',
            'text' => 'Текст новости номер 3, тро ло ло',
            'category_id' => 3
        ],
        4 => [
            'id' => 4,
            'title' => 'Новость №4',
            'text' => 'Текст новости номер 4, дрынь дрынь',
            'category_id' => 1
        ],
        5 => [
            'id' => 5,
            'title' => 'Новость №5',
            'text' => 'Текст новости номер 5, тро ло ло',
            'category_id' => 3
        ]
    ];

    public static function getNews()
    {
        return static::$news;
    }

    public static function getOneNews($id) {
        return static::$news[$id];
    }

    public static function getNewsByCategories($id) {
        $news = [];
        foreach (static::$news as $item) {
            if ($id == $item['category_id']) {
               array_push($news,$item);
            }
        }
        return $news;
    }


}
