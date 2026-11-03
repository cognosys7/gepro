<?php

namespace App\Http\Controllers;

class InicioController extends Controller
{
    public function __invoke()
    {
        return view('inicio');
    }
}
