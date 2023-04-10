<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Purchase extends BaseController
{
    public function index()
    {
        return view('purchases/menu');
    }
}
