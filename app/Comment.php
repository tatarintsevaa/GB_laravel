<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable= ['name', 'comment', 'is_approved', 'user_id', 'news_id', 'parent_id'];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id')->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->first();
    }

    public static function rules() {
        return [
            'name' => 'required|min:3|max:255|string',
            'comment' => 'required|min:3|string',
        ];
    }
}
