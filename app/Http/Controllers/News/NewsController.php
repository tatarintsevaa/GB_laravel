<?php

namespace App\Http\Controllers\News;

use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return view('news.news')->with('news', News::getNews()) ;
    }

    public function show($id)
    {
        return view('news.newsOne')->with('news', News::getOneNews($id)) ;
    }

}
