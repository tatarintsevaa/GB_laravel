<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = ['news_id', 'session_id'];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id')->first();
    }
}
