<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMoviesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $title;

    /**
     * Create a new job instance.
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(5);
        echo "Processed Task: " . json_encode($this->title) . "\n";
    }
}
