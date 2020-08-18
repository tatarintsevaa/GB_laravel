<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        return view('admin.index');
    }

    public function create() {
        return view('admin.create')->with('categories', Category::getCategories());
    }
}
