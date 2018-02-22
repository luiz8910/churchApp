<?php

namespace App\Http\Controllers;

use App\Repositories\ContactSiteRepository;
use App\Traits\EmailTrait;

class ContactSiteController extends Controller
{
    use EmailTrait;
    /**
     * @var ContactSiteRepository
     */
    private $repository;

    public function __construct(ContactSiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($data)
    {
        $data = \GuzzleHttp\json_decode($data);

        $d['name'] = $data[0];
        $d['email'] = $data[1];
        $d['tel'] = $data[2];
        $d['msg'] = $data[3];

        if($this->repository->create($d))
        {
            $this->contact_site($d['name'], $d['email'], $d['tel'], $d['msg']);

            return json_encode(['status' => true]);
        }


        return json_encode(['status' => false]);


    }
}
