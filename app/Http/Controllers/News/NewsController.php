<?php

namespace App\Http\Controllers\News;

use App\Comment;
use App\News;
use App\Service\BuildThreeService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::query()->paginate(8);
        return view('news.news')->with('news', $news);
    }

    public function show(News $news, BuildThreeService $buildThreeService)
    {

        $sessionId = Auth::getSession()->getId();
        if (!$news->views()->pluck('session_id')->contains($sessionId)) {
            $view = new View();
            $view->fill(['news_id' => $news->id, 'session_id' => $sessionId])->save();
        }

        $comments = $news->comments()->get()->toArray();
        $commentsThree = $buildThreeService->build($comments);

        return view('news.news_one')->with('news', $news)->with('comments', $commentsThree) ;
    }

    public function search(Request $request)
    {
        $data = $request->except('_token');
        $news = News::query()->where('text', 'Like', '%' . $data['search'] . '%')->paginate();
//        dd($news);

        return view('news.news')->with('news', $news);
    }
}
