<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Product extends BaseController
{
    public function index()
    {
        return view('products/data');
    }

    public function addFormPage()
    {
        return view('products/add');
    }
}
