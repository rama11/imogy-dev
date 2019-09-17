<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testcommand:test {parameter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is command testing';

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
        syslog(LOG_ERR, "Test Command Success " . $this->argument('parameter'));
        //
    }
}
