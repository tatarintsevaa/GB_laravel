<?php

namespace Tests\Unit;

use App\Category;
use App\News;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertIsArray(News::getNews());
        $this->assertIsArray(Category::getCategories());
    }
}
