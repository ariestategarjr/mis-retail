<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ProductsDatatableModel extends Model
{
    protected $table = 'produk';
    protected $column_order = [null, 'kodebarcode', 'namaproduk'];
    protected $column_search = ['kodebarcode', 'namaproduk'];
    protected $order = ['namaproduk' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;
}
