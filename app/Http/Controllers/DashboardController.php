<?php

namespace App\Http\Controllers;

use App\Repositories\CountRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use CountRepository;

    public function index()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        return view('dashboard.index', compact('countPerson', 'countGroups'));
    }
}
