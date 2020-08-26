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
    public function index() {
        return view('admin.news.index')->with('news', News::query()->paginate(20));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->flash();
            $data = $request->except('_token');

            if (in_array(null, $data)) {
                return redirect(route('admin.news.create'));
            }
            // наверно должно быть что то вроде News::create($data)->save()

            $filename = null;

            if ($request->file('image')) {
                $path = Storage::putFile('public/img', $request->file('image'));
                $filename = Storage::url($path);
            }
            $data['image'] = $filename;
            DB::table('news')->insert($data);
            return redirect()->route('news.show', ['id' => DB::getPdo()->lastInsertId()])
                ->with('success', 'Новость добавлена успешно!');
        }
        return view('admin.news.create');
    }

    public function download( Request $request)
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

    public function edit() {

        $news = News::query()->paginate(20);
        return view('admin.news.edit')->with('news', $news);
    }
}
