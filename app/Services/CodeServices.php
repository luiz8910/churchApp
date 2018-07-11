<?php

namespace App\Services;

use App\Mail\resetPasswordApp;
use App\Repositories\CodeRepository;
use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CodeServices{

    use ConfigTrait;
    /**
     * @var CodeRepository
     */
    private $codeRepository;

    public function __construct(CodeRepository $codeRepository)
    {

        $this->codeRepository = $codeRepository;
    }

    public function addCode($person)
    {
        $number = rand(1000, 9999);

        $old = $this->codeRepository->findByField('code', $number)->first();

        if(count($old) == 1)
        {
            $this->codeRepository->delete($old->id);
        }

        $tomorrow = date_create();

        date_add($tomorrow, date_interval_create_from_date_string('1 day'));

        $code['code'] = $number;

        $code['expires_in'] = date_format($tomorrow, 'Y-m-d H:i:s');

        if($this->codeRepository->create($code))
        {
            $today = date_format(date_create(), 'd/m/Y');

            $time = date_format(date_create(), 'H:i:s');

            $url = env('APP_URL');

            Mail::to($person->user)->send(new resetPasswordApp($person->user, $url, $today, $time, $number));

            return true;
        }

        return false;

    }


    public function getCode($code)
    {
        $result = $this->codeRepository->findByField('code', $code)->first();

        if(count($result) == 1)
        {
            $now = date_create();

            $exp = date_create($result->expires_in);

            if($exp > $now)
            {
                $data['expires_in'] = date_create();

                $this->codeRepository->update($data, $result->id);

                return json_encode(['status' => true]);
            }
            else{
                return $this->returnFalse('Código Expirado');
            }

        }

        return $this->returnFalse('Código informado não existe');

    }
}