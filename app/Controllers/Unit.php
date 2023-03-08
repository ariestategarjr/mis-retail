<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Unit extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'view_units',
            'active' => 'unit'
        ];
        return view('view_template', $data);
    }
}
