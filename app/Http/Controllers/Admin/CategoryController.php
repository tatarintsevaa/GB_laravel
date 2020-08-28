<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        return view('admin.categories.index');
    }


    public function create()
    {
        return view('admin.categories.create')->with('category', new Category());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        $category = new Category();
        $result = $category->fill($data)->save();
        if ($result) {
            return redirect()->route('admin.category.create')
                ->with('success', 'Категория успешно добавлена');
        } else {
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
        $data = $request->except('_token');

        $result = $category->fill($data)->save();

        if ($result) {
            return redirect()->route('admin.category.index')
                ->with('success', 'Категория успешно изменена');
        } else {
            return redirect()->route('admin.category.index')
                ->with('error', 'Ошибка изменения категории!');
        }
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index')
            ->with('success', 'Категория успешно удалена');
    }
}
