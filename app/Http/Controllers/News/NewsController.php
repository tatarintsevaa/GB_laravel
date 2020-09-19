<?php

namespace App\Http\Controllers\News;

use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::query()->paginate(8);
        return view('news.news')->with('news', $news);
    }

    public function show(News $news)
    {
        return view('news.news_one')->with('news', $news) ;
    }

    public function search(Request $request)
    {
        $data = $request->except('_token');
        $news = News::query()->where('text', 'Like', '%' . $data['search'] . '%')->paginate();
//        dd($news);

        return view('news.news')->with('news', $news);
    }
}
