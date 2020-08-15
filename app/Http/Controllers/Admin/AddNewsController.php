<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddNewsController extends Controller
{
    public function index() {
        return view('admin.addNews')->with('categories', Category::getCategories());
    }

    public function addNews() {

    }
}
