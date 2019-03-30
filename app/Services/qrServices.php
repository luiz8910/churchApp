<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class qrServices{

    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {

        $this->personRepository = $personRepository;
    }

    /*
     * $id = id da pessoa (person_id)
     */
    public function generateQrCode($id) : bool 
    {
        $person = $this->personRepository->findByField('id', $id)->first();

        if($person)
        {
            try{

                DB::beginTransaction();

                $path = 'qrcodes/'.$id.'.png';

                $x['qrCode'] = $path;

                $this->personRepository->update($x, $id);

                QrCode::format('png')->generate($id, $path);

                DB::commit();

                return true;

            }catch (\Exception $e)
            {
                DB::rollBack();

                return false;
            }

        }

        return false;
    }
}
