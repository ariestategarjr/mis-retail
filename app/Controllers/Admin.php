<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'view_dashboard',
            'title' => 'Dashboard',
            'subtitle' => '',
            'menu' => 'dashboard',
            'submenu' => ''
        ];
        return view('view_template', $data);
    }

    public function sale()
    {
        $data = [
            'page' => 'view_sale',
            'title' => 'Sale',
            'subtitle' => '',
            'menu' => 'sale',
            'submenu' => ''
        ];
        return view('view_template', $data);
    }

    public function setting()
    {
        $data = [
            'page' => 'view_settings',
            'title' => 'Settings',
            'subtitle' => '',
            'menu' => 'settings',
            'submenu' => ''
        ];
        return view('view_template', $data);
    }
}
