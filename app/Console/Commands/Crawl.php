<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helmet:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'クロールするぞ！';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apps = \App\App::all();
        foreach ($apps as $app) {
            if (! class_exists($app->crawler)) {
                throw new \InvalidArgumentException("Crawler class not exists: $app->crawler");
            }
            $crawler = new $app->crawler($app->config);
            $crawler->handle();
        }
    }
}
