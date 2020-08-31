<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateNewsTest extends DuskTestCase
{

    public function testValidCreate(): void
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/create')
                ->assertSee('Добавить новость')
                ->select('category_id', '1')
                ->type('title', 'test')
                ->type('text', 'test')
                ->attach('image', '/home/vagrant/test.jpeg')
                ->press('Опубликовать')
                ->assertPathIs('//admin/news/create')
                ;
        });
    }

    public function testInvalidCreate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/create')
                ->assertSee('Добавить новость')
                ->select('category_id', '1')
                ->type('title', '')
                ->type('text', 'test')
                ->attach('image', '/home/vagrant/test.doc')
                ->press('Опубликовать')
                ->assertPathIs('//admin/news/create')
                ->assertSee('Поле Заголовок новости обязательно для заполнения.')
                ->assertSee('Поле Изображение должно быть файлом одного из следующих типов: jpeg, bmp, png.')
            ;
        });
    }
}
