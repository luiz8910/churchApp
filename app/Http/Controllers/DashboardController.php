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

        $countGroups = $this->countGroups();

        return view('dashboard.index', compact('countPerson', 'countGroups'));
    }
}
