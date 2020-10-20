<?php


namespace App\Service;


use App\Category;
use App\News;
use Illuminate\Support\Str;
use Orchestra\Parser\Xml\Facade as XmlParser;

class XMLParserService
{
    public function saveNews($link)
    {
        $xml = XmlParser::load($link);
//        dump($xml);
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
//        dump($categoriesCollect->toArray());

        foreach ($data['news'] as $item) {
            if ((!is_null($item['category']) && !$categoriesCollect->contains($item['category'])) ||
                (is_null($item['category']) && !$categoriesCollect->contains($data['title']))) {
                $newCategoriesData->add([
                    'name' => $item['category'] ?? $data['title'],
                    'slug' => Str::slug($item['category'] ?? Str::slug($data['title']))
                ]);
                if (is_null($item['category'])) {
                    $categoriesCollect->add($data['title']);
                } else {
                    $categoriesCollect->add($item['category']);
                }
            }
        }
//        dump($categoriesCollect->toArray());
//        dd($newCategoriesData->toArray());
        Category::query()->insert($newCategoriesData->toArray());
        $categories = collect(Category::all())->keyBy('name')->toArray();
        $newsCollect = collect(News::all()->pluck('title'));
        $newNewsData = collect();
        foreach ($data['news'] as $item) {
            if (!$newsCollect->contains($item['title'])) {
                $categoryName = $item['category'] ?? $data['title'];
                $categoryId = $categories[$categoryName]['id'];
//                $categoryId = Category::query()->where('name', $item['category'])->pluck('id')->first();
                $newNewsData->add([
                    'title' => $item['title'],
                    'text' => $item['description'],
                    'image' => $item['enclosure::url'],
                    'category_id' => $categoryId,
                    'link' => $item['link']
                ]);
                $newsCollect->add($item['title']);
            }
        }
        News::query()->insert($newNewsData->toArray());
    }
}
