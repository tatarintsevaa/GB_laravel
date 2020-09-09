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

    public function create()
    {
        return view('admin.news.create')
            ->with('news', new News())
            ->with('categories', Category::all());
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
        return view('admin.news.download')->with('categories', Category::all());
    }

    public function edit(News $news)
    {
        return view('admin.news.create')
            ->with('news', $news)
            ->with('categories', Category::all());
    }

    public function update(News $news, Request $request)
    {
        $messages = [
            'success' => 'Новость успешно сохранена',
            'error' => 'Ошибка сохранения новости'
        ];
        return $this->saveData($news, $request, $messages);
    }

    public function store(Request $request)
    {
        $messages = [
            'success' => 'Новость успешно опубликована',
            'error' => 'Ошибка добавления новости'
        ];

        return $this->saveData(new News(), $request, $messages);

    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно удалена');
    }

    private function saveData(News $news, Request $request, $messages)
    {
        $data = $request->except('_token');
        if ($request->file('image')) {
            $path = Storage::putFile('public/img', $request->file('image'));
            $filename = Storage::url($path);
            $data['image'] = $filename;
        }


        $this->validate($request, News::rules(), [], News::attrNames());

        $result = $news->fill($data)->save();

        if ($result) {
            if ($request->getMethod() == 'POST')
                return redirect()->route('admin.news.create')->with('success', $messages['success']);
            elseif ($request->getMethod() == 'PUT') {
                return redirect()->route('admin.news.index')->with('success', $messages['success']);
            }
        } else {
            $request->flash();
            return redirect()->route('admin.news.create')->with('error', $messages['error']);
        }
    }


}
