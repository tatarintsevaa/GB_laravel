<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::query()->paginate(20);
        return view('admin.news.index')->with('news', $news);
    }

    public function create(Request $request)
    {
        return view('admin.news.create')->with('news', new News());
    }

    public function download(Request $request)
    {


        if ($request->isMethod('post')) {
            $categoryId = $request->only('category')['category'];
            $categoryName = Category::query()->find($categoryId)->slug;
            return response()->json(Category::find($categoryId)->news)
                ->header('Content-Disposition', "attachment; filename = {$categoryName}.json")
                ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        return view('admin.news.download');
    }

    public function edit(News $news)
    {
        return view('admin.news.create')
            ->with('news', $news);
    }

    public function update(News $news, Request $request)
    {
        $data = $request->except('_token');

        if ($request->file('image')) {
            $path = Storage::putFile('public/img', $request->file('image'));
            $filename = Storage::url($path);
            $data['image'] = $filename;
        }

        if (!array_key_exists('isPrivate', $data)) {
            $data['isPrivate'] = 0;
        }
        $news->fill($data)->save();

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно сохранена!');


    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $filename = null;
        if ($request->file('image')) {
            $path = Storage::putFile('public/img', $request->file('image'));
            $filename = Storage::url($path);
        }
        $data['image'] = $filename;

        $news = new News();

        $result = $news->fill($data)->save();

        if ($result) {
            return redirect()->route('admin.news.create')
                ->with('success', 'Новость успешно добавлена');
        } else {
            return redirect()->route('admin.news.create')->with('error', 'Ошибка добавления новости!');
        }
    }

    public function destroy(News $news) {
        $news->delete();
        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно удалена');
    }



}
