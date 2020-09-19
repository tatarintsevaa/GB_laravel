<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        return view('admin.categories.index')->with('categories', Category::all());
    }


    public function create()
    {
        return view('admin.categories.create')->with('category', new Category());
    }


    public function store(Request $request)
    {
        $result = $this->saveData($request, new Category());
        if ($result) {
            return redirect()->route('admin.category.create')
                ->with('success', 'Категория успешно добалена');
        } else {
            $request->flash();
            return redirect()->route('admin.category.create')
                ->with('error', 'Ошибка добавления категории!');
        }
    }


    public function edit(Category $category)
    {
        return view('admin.categories.create')->with('category', $category);
    }


    public function update(Request $request, Category $category)
    {

        $result = $this->saveData($request, $category);
        if ($result) {
            return redirect()->route('admin.category.index')
                ->with('success', 'Категория успешно изменена');
        } else {
            $request->flash();
            return redirect()->route('admin.category.create')
                ->with('error', 'Ошибка изменения категории!');
        }

    }

    private function saveData(Request $request, Category $category)
    {
        $data = $request->except('_token');

        $this->validate($request, Category::rules(), [], Category::attrNames());
        return $category->fill($data)->save();

    }


    public function destroy(Category $category)
    {
        $news = $category->news()->get();
        if ($news->isEmpty()) {
            $category->delete();
            return redirect()->route('admin.category.index')
                ->with('success', 'Категория успешно удалена');
        } else {
            return redirect()->route('admin.category.index')
                ->with('error', "Удаление отменено. Сначала удалите все новости категории {$category->name }");
        }
    }
}
