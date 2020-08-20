<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) { // мне не нравиться что тут аж 3 return...в данном случае это норм ?
            $request->flash();
            $newNews = $request->except('_token');
            if (in_array(null, $newNews)) {
                return redirect(route('admin.create'));
            }
            $allNews = News::getNews();
            $newsCount = (int)count($allNews);
            $newNews['id'] = $newsCount + 1;
            $allNews += [$newsCount + 1 => $newNews];
            \Storage::put('public/news.json', json_encode($allNews, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            return redirect()->route('newsOne', ['id' => $newNews['id']]);
        }
        return view('admin.create');
    }

    public function download(Request $request)
    {
        if ($request->isMethod('post')) {
            $category_id = $request->only('category')['category'];
            $category_name = Category::getOneCategory("{$category_id}")['slug'];
            return response()->json(News::getNewsByCategories($category_id))
                ->header('Content-Disposition', "attachment; filename = {$category_name}.json")
                ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        return view('admin.download');
    }
}
