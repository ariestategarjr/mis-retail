<?php

namespace App\Models;

use CodeIgniter\Model;

class SuppliersModel extends Model
{
    protected $table            = 'supplier';
    protected $primaryKey       = 'sup_kode';
    protected $allowedFields    = [
        'sup_kode',
        'sup_nama',
        'sup_alamat',
        'sup_telp'
    ];
}
