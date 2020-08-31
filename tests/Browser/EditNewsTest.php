<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditNewsTest extends DuskTestCase
{
    public function testValidEdit(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/edit/2')
                ->assertSee('Редактирование новости 2')
                ->select('category_id', '1')
                ->type('title', 'test')
                ->type('text', 'test')
                ->press('Сохранить')
                ->assertPathIs('/admin/news')
            ;
        });
    }
    public function testInvalidEdit(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/edit/2')
                ->assertSee('Редактирование новости 2')
                ->select('category_id', '1')
                ->type('title', '')
                ->type('text', 'test')
                ->attach('image', '/home/vagrant/test.doc')
                ->press('Сохранить')
                ->assertPathIs('//admin/news/edit/2') // не понимаю почему он ожидает 2 слеша...
                ->assertSee('Поле Заголовок новости обязательно для заполнения.')
                ->assertSee('Поле Изображение должно быть файлом одного из следующих типов: jpeg, bmp, png.');
        });

    }

}



