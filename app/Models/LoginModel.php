<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table            = 'akun';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'username', 'password', 'status'];
}
