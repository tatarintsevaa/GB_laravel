<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'slug'];

    public function news() {
        return $this->hasMany(News::class, 'category_id');
    }

    public static function rules()
    {
        return [
            'name' => 'required|min:3|max:200',
            'slug' => 'required|min:3'
        ];
    }

    public static function attrNames()
    {
        return [
            'name' => 'Наименование',
            'slug' => 'Английское название'
        ];
    }
}
