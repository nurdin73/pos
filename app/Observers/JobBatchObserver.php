<?php

namespace App\Observers;

use App\Models\JobBatches;
use Illuminate\Support\Facades\Log;

class JobBatchObserver
{
    /**
     * Handle the JobBatches "created" event.
     *
     * @param  \App\Models\JobBatches  $jobBatches
     * @return void
     */
    public function created(JobBatches $jobBatches)
    {
        //
    }

    /**
     * Handle the JobBatches "updated" event.
     *
     * @param  \App\Models\JobBatches  $jobBatches
     * @return void
     */
    public function updated(JobBatches $jobBatches)
    {
        Log::info('updating bos');
    }

    /**
     * Handle the JobBatches "deleted" event.
     *
     * @param  \App\Models\JobBatches  $jobBatches
     * @return void
     */
    public function deleted(JobBatches $jobBatches)
    {
        //
    }

    /**
     * Handle the JobBatches "restored" event.
     *
     * @param  \App\Models\JobBatches  $jobBatches
     * @return void
     */
    public function restored(JobBatches $jobBatches)
    {
        //
    }

    /**
     * Handle the JobBatches "force deleted" event.
     *
     * @param  \App\Models\JobBatches  $jobBatches
     * @return void
     */
    public function forceDeleted(JobBatches $jobBatches)
    {
        //
    }
}
