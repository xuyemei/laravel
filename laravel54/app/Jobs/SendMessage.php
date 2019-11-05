<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notice;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //给所有用户发送系统通知
        $users = \App\User::all();
        foreach ($users as $user){
            $user->addNotice($this->notice);
        }
    }
}
