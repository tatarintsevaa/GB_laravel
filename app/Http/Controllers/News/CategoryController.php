<?php

namespace App\Http\Controllers\News;

use App\Category;
use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return view('news.news_categories')->with('categories', Category::all());
    }

    public function show(string $name) {
        $category = Category::query()->where('slug', $name)->first();
        $news = Category::find($category->id)->news()->orderByDesc('id')->paginate(8);
        return view('news.news')
            ->with('news', $news)
            ->with('category', $category->name);
    }
}
