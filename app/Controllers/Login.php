<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Login extends BaseController
{
    public function __construct()
    {
        $this->logins = new LoginModel();
    }

    public function index()
    {
        return view('login/login');
    }

    public function actionLogin()
    {
        $username = esc($this->request->getPost('username'));
        $password = esc($this->request->getPost('password'));

        $where = [
            'username' => $username,
            'password' => $password,
        ];

        $checkData = $this->logins->where($where)->get()->getRowArray();

        if (!isset($checkData)) {
            session()->setFlashdata('gagal', 'Username / Password salah');
            return redirect()->to(base_url('login'));
        } else {
            session()->set('username', $checkData['username']);
            session()->set('status', $checkData['status']);
            session()->set('id', $checkData['id']);
            return redirect()->to('home/index');
        }
    }

    public function actionLogout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
