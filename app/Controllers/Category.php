<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;

class Category extends BaseController
{
    public function __construct()
    {
        $this->categories = new CategoriesModel();
    }

    public function index()
    {
        $data = [
            'categories' => $this->categories->findAll()
        ];

        return view('pages/categories', $data);
    }
}
