<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Layout extends BaseController
{
    public function index()
    {
        return view('pages/home');
    }
}
