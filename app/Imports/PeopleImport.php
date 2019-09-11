<?php

namespace App\Imports;

use App\Jobs\Import;
use App\Models\Person;
use App\Services\qrServices;
use App\Traits\ConfigTrait;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PeopleImport implements ToCollection, WithChunkReading, ShouldQueue
{
    use ConfigTrait, UserLoginRepository, PeopleTrait;

    public function chunkSize(): int
    {
        // TODO: Implement chunkSize() method.
        return 100;
    }

    public function collection(Collection $rows)
    {
        // TODO: Implement collection() method.

        foreach ($rows as $row)
        {
            if(!$row[0])
            {
                break;
            }
            else{

                Import::dispatch($row);
            }

        }
    }
}
