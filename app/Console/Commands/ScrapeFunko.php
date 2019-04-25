<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;


class ScrapeFunko extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:bankingdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Funko POP! Vinyl Scraper';

    /**
     * The list of funko collection slugs.
     *
     * @var array
     */
    protected $collections = [
        'women',
        'agriculture',
        'education',
        'refugees-and-i-d-ps',
        'eco-friendly',
        'kiva-u-s',
        'livestock',
        'arts'
    ];

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
        foreach ($this->collections as $collection) {
            $this->scrape($collection);
        }
    }

    /**
     * For scraping data for the specified collection.
     *
     * @param  string $collection
     * @return boolean
     */
    public static function scrape($collection)
    {
		$arb = [];
		//dd(env('FUNKO_POP_URL'));
        //$crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection);
		$goutte = new Client();
		$crawler = $goutte->request('GET', env('KIVA_LOAN_BASE_URL'));
        $pages = ($crawler->filter('ul#lend-menu-category-panel li')->count() > 0)
            ? $crawler->filter('ul#lend-menu-category-panel li')->text()
            : 0;
                //$crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection.'?page='.$i);
		$crawler = $goutte->request('GET', env('KIVA_LOAN_CAT_URL').'/'.$collection);
         
            $crawler->filter('div.loan-card-group')->each(function ($node) {
                //$sku   = explode('#', $node->filter('.product-sku')->text())[1];
                //$title = trim($node->filter('.title a')->text());
				//dd($node->filter('div.column-block'));
                $arb = $node->filter('div.column-block a')->extract(array('href'));
				print_r(array_unique($arb));
            });
    }
}
