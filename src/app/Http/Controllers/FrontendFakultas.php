<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultasdata;

class FrontendFakultas extends Controller
{
    public function home()
    {
        $fakultasdatas = Fakultasdata::get();
        return view('Fakultas.index', compact('fakultasdatas'));

    }
    public function index()
    {
        $fakultasdatas = Fakultasdata::get();
        return view('Fakultas.fakultas', compact('fakultasdatas'));
        
    }
}
