<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Orchestra\Parser\Xml\Facade as XmlParser;

class ParserController extends Controller
{
    public function index() {
        $xml = XmlParser::load('https://lenta.ru/rss');
        $data = $xml->parse([
            'title' => ['uses' => 'channel.title'],
            'link' => ['uses' => 'channel.link'],
            'description' => ['uses' => 'channel.description'],
            'image' => ['uses' => 'channel.image.url'],
            'news' => ['uses' => 'channel.item[guid,title,link,description,pubDate,enclosure::url,category]'],
        ]);
//        dd($data);
        foreach ($data['news'] as $item) {
            $category = Category::query()->where('name', $item['category'])->first();
            if (is_null($category)) {
                $category = new Category();
                $category->fill([
                    'name' => $item['category'],
                    'slug' => Str::slug($item['category'])
                ]);
                $category->save();
            }
            $news = News::query()->where('title', $item['title'])->first();
                if (is_null($news)) {
                    $news = new News();
                    $news->fill([
                        'title' => $item['title'],
                        'text' => $item['description'],
                        'image' => $item['enclosure::url'],
                        'category_id' => $category->id
                    ]);
                    $news->save();
                }

        }
       return redirect() ->route('home');
    }
}
