<?php


namespace App\Service;


use App\Category;
use App\News;
use Illuminate\Support\Str;
use Orchestra\Parser\Xml\Facade as XmlParser;

class XMLParserService
{
    private $categories = [
        'Главное' => ['главное', 'Главное'],
        'Авто' => ['авто', 'автоспорт'],
        'Силовые структуры' => ['силовые структуры', 'армия', 'оружие'],
        'ИТ новости' => ['гаджеты', 'интернет', 'игры', 'киберспорт', 'ит'],
        'Медицина' => ['медицина', 'здоровье', 'игры', 'киберспорт'],
        'Спорт' => ['спорт', 'единоборства', 'лига чемпионов', 'нхл'],
        'Наука' => ['космос', 'техника', 'лига чемпионов', 'нхл'],
        'Культура' => ['культура', 'кино', 'лига чемпионов', 'нхл'],
        'Музыка' => ['музыка'],
        'ЖКХ' => ['жкх'],
    ];

    private function categoriesFilter(string $category): string
    {

        foreach ($this->categories as $name => $values) {
            foreach ($values as $item) {
                if (Str::contains(Str::lower($category), $item)) {
                    $category = $name;
                }
            }
        }
        return $category;
    }

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
            $category = $this->categoriesFilter($item['category'] ?? $data['title']);
            if (!$categoriesCollect->contains($category)) {
                $newCategoriesData->add([
                    'name' => $category,
                    'slug' => Str::slug($category)
                ]);
                $categoriesCollect->add($category);
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
                $categoryName = $this->categoriesFilter($item['category'] ?? $data['title']);
                $categoryId = $categories[$categoryName]['id'];
                $newNewsData->add(['title' => $item['title'],
                    'text' => $item['description'],
                    'image' => $item['enclosure::url'],
                    'category_id' => $categoryId,
                    'link' => $item['link']]);
                $newsCollect->add($item['title']);
            }
        }
        News::query()->insert($newNewsData->toArray());
    }
}
