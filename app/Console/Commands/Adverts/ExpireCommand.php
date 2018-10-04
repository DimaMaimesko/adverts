<?php

namespace App\Console\Commands\Adverts;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\Advert\AdvertService;
use App\Models\Adverts\Advert;

class ExpireCommand extends Command
{
    protected $signature = 'advert:expire';

    private $service;

    public function __construct(AdvertService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): bool
    {
        $success = true;

        foreach (Advert::active()->where('expires_at', '<', Carbon::now())->cursor() as $advert) {
            try {
                $this->service->expire($advert);
            } catch (\DomainException $e) {
                $this->error($e->getMessage());
                $success = false;
            }
        }

        return $success;
    }
}