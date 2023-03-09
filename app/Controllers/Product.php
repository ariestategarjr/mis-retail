<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Product extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'view_products',
            'title' => 'Master',
            'subtitle' => 'Products',
            'menu' => 'master',
            'submenu' => 'products'
        ];
        return view('view_template', $data);
    }
}
