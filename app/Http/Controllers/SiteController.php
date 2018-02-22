<?php

namespace App\Http\Controllers;

use App\Repositories\SiteRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @var SiteRepository
     */
    private $repository;

    public function __construct(SiteRepository $repository)
    {

        $this->repository = $repository;
    }

    public function index()
    {
        return view('site.home');
    }
}
