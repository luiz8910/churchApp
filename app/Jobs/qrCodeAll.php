<?php

namespace App\Jobs;

use App\Repositories\PersonRepository;
use App\Services\qrServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class qrCodeAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PersonRepository $personRepository, qrServices $qrServices)
    {
        $people = DB::table('people')->limit(1)->get();


        foreach ($people as $person)
        {

            $qrServices->generateQrCode($person->id);


        }
    }
}
