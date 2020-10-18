<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'text', 'isPrivate', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->first();
    }

    public function views() {
        return $this->hasMany(View::class, 'news_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'news_id');
    }

    public static function rules()
    {
        $tableNameCategory = (new Category())->getTable();
        return [
            'title' => ['required', 'min:3', 'max:200'],
            'text' => 'required|min:3',
            'image' => 'mimes:jpeg,bmp,png|max:1000',
            'isPrivate' => 'sometimes|in:1',
            'category_id' => "required|exists:{$tableNameCategory},id"
        ];
    }

    public static function attrNames()
    {
        return [
            'title' => 'Заголовок новости',
            'text' => 'Текст новости',
            'category_id' => "Категория новости",
            'image' => "Изображение"
        ];
    }
}
