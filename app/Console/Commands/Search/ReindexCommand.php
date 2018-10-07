<?php

namespace App\Console\Commands\Search;

use Illuminate\Console\Command;
use App\Models\Adverts\Advert;
use App\Services\Search\AdvertIndexer;

class ReindexCommand extends Command
{
    protected $signature = 'search:reindex';

    private $adverts;

    public function __construct(AdvertIndexer $adverts)
    {
        parent::__construct();
        $this->adverts = $adverts;
    }

    public function handle(): bool
    {
        $this->adverts->clear();

        foreach (Advert::active()->orderBy('id')->cursor() as $advert) {
            $this->adverts->index($advert);
        }
        return true;
    }
}



