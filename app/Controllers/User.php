<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'view_users'
        ];
        return view('view_template', $data);
    }
}
