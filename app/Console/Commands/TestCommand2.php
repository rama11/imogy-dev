<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class TestCommand2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testcommand2:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is command testing2';

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
        //
        Artisan::call('testcommand:test',[
            'parameter' => 'parameter'
        ]);
    }
}
