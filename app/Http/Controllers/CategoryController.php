<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return view('news.newsCategories')->with('categories', Category::getCategories());
    }

    public function show(string $name) {
        $category_id = Category::getCategoryIdByName($name);
        return view('news.news')->with('news', News::getNewsByCategories($category_id));
    }
}
