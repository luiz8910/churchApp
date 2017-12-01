<?php

namespace App\Http\Controllers;

use App\Repositories\ChurchRepository;
use Illuminate\Http\Request;

class ChurchController extends Controller
{
    /**
     * @var ChurchRepository
     */
    private $repository;

    public function __construct(ChurchRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getChurchesApi()
    {
        $churches = $this->repository->all();

        return json_encode($churches);
    }
}
