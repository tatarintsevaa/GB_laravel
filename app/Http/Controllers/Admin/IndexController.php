<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->flash();
            $data = $request->except('_token');

            if (in_array(null, $data)) {
                return redirect(route('admin.create'));
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
        return view('admin.create');
    }

    public function download(Request $request)
    {
        if ($request->isMethod('post')) {
            $category_id = $request->only('category')['category'];
            $category_name = Category::getOneCategory("{$category_id}")->slug;
            return response()->json(News::getNewsByCategories($category_id))
                ->header('Content-Disposition', "attachment; filename = {$category_name}.json")
                ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        return view('admin.download');
    }
}
