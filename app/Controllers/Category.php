<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;

class Category extends BaseController
{
    public function __construct()
    {
        $this->categoriesModel = new CategoriesModel();
    }

    public function index()
    {
        $data = [
            // 'categories' => $this->categoriesModel->findAll()
            'categories' => $this->categoriesModel->paginate(2),
            'pager' => $this->categoriesModel->pager
        ];

        return view('pages/categories', $data);
    }
}
