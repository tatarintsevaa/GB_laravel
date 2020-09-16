<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Orchestra\Parser\Xml\Facade as XmlParser;

class ParserController extends Controller
{
    public function index()
    {
        $xml = XmlParser::load('https://lenta.ru/rss');
        $data = $xml->parse([
            'title' => ['uses' => 'channel.title'],
            'link' => ['uses' => 'channel.link'],
            'description' => ['uses' => 'channel.description'],
            'image' => ['uses' => 'channel.image.url'],
            'news' => ['uses' => 'channel.item[guid,title,link,description,pubDate,enclosure::url,category]'],
        ]);
//        dd($data);
        $categoriesCollect = collect(Category::all()->pluck('name'));
        $newCategoriesData = collect();
        foreach ($data['news'] as $item) {
            if (!$categoriesCollect->contains($item['category'])) {
                $newCategoriesData->add([
                    'name' => $item['category'],
                    'slug' => Str::slug($item['category'])
                ]);
                $categoriesCollect->add($item['category']);
            }
        }
        Category::query()->insert($newCategoriesData->toArray());
        $categories = collect(Category::all())->keyBy('name')->toArray();
        $newsCollect = collect(News::all()->pluck('title'));
        $newNewsData = collect();
        foreach ($data['news'] as $item) {
            if (!$newsCollect->contains($item['title'])) {
                $categoryId = $categories[$item['category']]['id'];
//                $categoryId = Category::query()->where('name', $item['category'])->pluck('id')->first();
                $newNewsData->add([
                    'title' => $item['title'],
                    'text' => $item['description'],
                    'image' => $item['enclosure::url'],
                    'category_id' => $categoryId
                ]);
                $newsCollect->add($item['title']);
            }
        }
        News::query()->insert($newNewsData->toArray());

//        dd(News::all());
//        foreach ($data['news'] as $item) { // TODO переделать метод . Использовать минимум запросов. сначала дернуть все категории и впроверять в пхп.
//            $category = Category::query()->where('name', $item['category'])->first();
//            if (is_null($category)) {
//                $category = new Category();
//                $category->fill([
//                    'name' => $item['category'],
//                    'slug' => Str::slug($item['category'])
//                ]);
//                $category->save();
//            }
//            $news = News::query()->where('title', $item['title'])->first();
//            if (is_null($news)) {
//                $news = new News();
//                $news->fill([
//                    'title' => $item['title'],
//                    'text' => $item['description'],
//                    'image' => $item['enclosure::url'],
//                    'category_id' => $category->id
//                ]);
//                $news->save();
//            }
//
//        }
        return redirect()->route('home');
    }
}
