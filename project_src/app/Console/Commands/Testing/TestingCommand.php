<?php

namespace App\Console\Commands\Testing;

use App\Http\Helpers\Vendor\BinanceHelper;
use Illuminate\Console\Command;

class TestingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing';

    protected $posTransactionDecorator;

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
        BinanceHelper::test();
    }
}