<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UsersCondition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UsersCondition:condition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all users condition';

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
        $condition = DB::table('users')
            ->update(['condition' => "off"]);
    }
}
