<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $lastNews = DB::table('news')->get()->last();
        $lastListNews = DB::table('news')->orderByDesc('id')->limit(5)->get();
        return view('index')
            ->with('lastNews', $lastNews)
            ->with('lastListNews', $lastListNews);
    }
}
