<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\MailRemainderProject;
use Mail;

class QueueEmailRemainder implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $data;
	public $tries = 3;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($data)
	{
		//
		$this->data = $data;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$data = $this->data;

		// Mail::to($data["to"])
		//     ->cc($data["cc"])
		Mail::to("agastya@sinergy.co.id")
			->cc("prof.agastyo@gmail.com")
			->send(new MailRemainderProject($data));
	}
}
