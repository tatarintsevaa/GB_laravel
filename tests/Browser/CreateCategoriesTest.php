<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCategoriesTest extends DuskTestCase
{
    public function testValidCreate(): void
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/category/create')
                ->assertSee('Добавить категорию')
                ->type('name', 'test')
                ->type('slug', 'test')
                ->press('Добавить')
                ->assertPathIs('/admin/category/create')
            ;
        });
    }

    public function testInvalidCreate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/category/create')
                ->assertSee('Добавить категорию')
                ->type('name', '')
                ->type('slug', 'test')
                ->press('Добавить')
                ->assertPathIs('//admin/category/create')
                ->assertSee('Поле Наименование обязательно для заполнения.')
            ;
        });
    }
}
