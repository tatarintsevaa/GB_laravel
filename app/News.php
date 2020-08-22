<?php

namespace App;

use Illuminate\Support\Facades\DB;

class News
{

    public static function getNews()
    {
        return DB::table('news')->get();
    }

    public static function getOneNews($id) {
        return DB::table('news')->find($id) ?? null;
    }

    public static function getNewsByCategories($id) {
       return DB::table('news')->where('category_id', $id)->get();
    }


}
