<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
class OpenApiCommand extends Command
{
    protected $signature = 'swagger:create';

    protected $description = 'Create json annotation';

    public function handle()
    {


        $openapi = \Swagger\scan('app');
        header('Content-Type: application/x-yaml');
        echo $openapi;
        return true;
    }
}
