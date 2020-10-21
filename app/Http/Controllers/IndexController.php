<?php

namespace App\Http\Controllers;

use App\Category;
use App\Jobs\NewsParsing;
use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        $lastNews = DB::table('news')->whereNotNull('image')->get()->last();
        $lastListNews = DB::table('news')->orderByDesc('id')->limit(5)->get();
        return view('index')
            ->with('lastNews', $lastNews)
            ->with('lustNewsList', $lastListNews);
    }
}
