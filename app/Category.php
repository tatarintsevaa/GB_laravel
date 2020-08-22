<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;
use Illuminate\Support\Facades\DB;

class Category
{
    public static function getCategories() {
        return DB::table('categories')->get();
    }

    public static function getOneCategory($id) {
        return DB::table('categories')->find($id);
    }

    public static function getCategoryIdByName(string $name) {
        return DB::table('categories')->where('slug', $name)->value('id');
    }


}
