<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Resource;
use App\Service\XMLParserService;
use App\Jobs\NewsParsing;

class ParserController extends Controller
{
    public function index(XMLParserService $parserService)
    {
        $rssLinks = Resource::all();
        foreach ($rssLinks as $link) {
            NewsParsing::dispatch($link->link);
        }

        return redirect()->route('home');
    }
}
