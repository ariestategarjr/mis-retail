<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Category extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'view_categories',
            'title' => 'Master',
            'subtitle' => 'Categories',
            'menu' => 'master',
            'submenu' => 'categories'
        ];
        return view('view_template', $data);
    }
}
