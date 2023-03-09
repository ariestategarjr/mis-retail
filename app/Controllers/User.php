<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'view_users',
            'title' => 'Master',
            'subtitle' => 'Users',
            'menu' => 'master',
            'submenu' => 'users'
        ];
        return view('view_template', $data);
    }
}
