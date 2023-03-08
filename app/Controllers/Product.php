<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Product extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'view_products',
            'active' => 'product'
        ];
        return view('view_template', $data);
    }
}
