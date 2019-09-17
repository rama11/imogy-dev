<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use DB;
use Mail;

class SendAllProjectRemainder extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'SendAllProjectRemainder:send_all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'To send all project with SendProjectRemainder artisan command';

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

		syslog(LOG_NOTICE, "Checking project remainder");

		$projectAll = DB::table('project__list')
			->pluck('id')
			->toArray();

		foreach ($projectAll as $id) {
			Artisan::call('ProjectRemainder:send',[
				'id' => $id
			]);
		}
	}
}
