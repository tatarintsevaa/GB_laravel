<?php

namespace App\Jobs;

use App\Service\XMLParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NewsParsing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $link;


    public function __construct($link)
    {
        $this->link = $link;
    }


    public function handle(XMLParserService $parserService)
    {
        $parserService->saveNews($this->link);
    }
}
