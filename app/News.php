<?php

namespace App;

use App\Rules\Ember;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'text', 'isPrivate', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->first();
    }

    public static function rules()
    {
        $tableNameCategory = (new Category())->getTable();
        return [
            'title' => ['required', 'min:3', 'max:200'],
            'text' => 'required|min:3',
            'image' => 'mimes:jpeg,bmp,png|max:1000',
//            'isPrivate' => 'sometimes|in:on', // TODO переделать
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
