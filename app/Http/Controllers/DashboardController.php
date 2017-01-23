<?php

namespace App\Http\Controllers;

use App\Repositories\CountPersonRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use CountPersonRepository;

    public function index()
    {
        $countPerson[] = $this->countPerson();

        return view('dashboard.index', compact('countPerson'));
    }
}
