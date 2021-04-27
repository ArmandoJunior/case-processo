<?php

namespace App\Console\Commands;

use App\Service\classes\SanitizerField;
use App\Service\FileProcessing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReadFilesToDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'readfile:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read a big file and persist to db';

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
        Log::info('Start readfile!');
        $sanitizer = new SanitizerField();
        $result = (new FileProcessing($sanitizer))->fileProcess();
        Log::info("End readfile: $result");
    }
}
