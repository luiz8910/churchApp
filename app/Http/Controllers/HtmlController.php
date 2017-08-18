<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HtmlController extends Controller
{
    public function teste()
    {
        return view('nome.view');
    }
}
