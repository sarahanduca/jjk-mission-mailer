<?php
namespace App\Jobs;

use App\Mail\MissionAssignedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendAssignMissionMail implements ShouldQueue
{
    use Queueable;

    protected $mission;
    protected $sorcerer;

    /**
     * Create a new job instance.
     */
    public function __construct($mission, $sorcerer)
    {
        $this->mission  = $mission;
        $this->sorcerer = $sorcerer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->sorcerer->email)
            ->queue(new MissionAssignedMail($this->mission, $this->sorcerer->name, $this->sorcerer->id));
    }
}
