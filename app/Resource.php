<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['link'];

    public static function rules()
    {
        return [
            'link' => ['required'],
        ];
    }
}
