<?php

namespace App\Http\Controllers\News;

use App\Category;
use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return view('news.newsCategories');
    }

    public function show(string $name) {
        $category_id = Category::getCategoryIdByName($name);
        return view('news.news')
            ->with('news', News::getNewsByCategories($category_id))
            ->with('category', Category::getOneCategory($category_id)->name);
    }
}
