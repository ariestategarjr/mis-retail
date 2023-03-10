<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUnits;

class Unit extends BaseController
{
    public function __construct()
    {
        // parent::__construct();
        $this->ModelUnits = new ModelUnits();
    }

    public function index()
    {
        $data = [
            'page' => 'view_units',
            'title' => 'Master',
            'subtitle' => 'Units',
            'menu' => 'master',
            'submenu' => 'units',
            'satuan' => $this->ModelUnits->getAll()
        ];
        return view('view_template', $data);
    }
}
