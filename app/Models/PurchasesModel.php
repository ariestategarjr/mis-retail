<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchasesModel extends Model
{
    protected $table            = 'pembelian_detail';
    protected $primaryKey       = 'detbeli_id';
    protected $allowedFields    = [
        'detbeli_id',
        'detbeli_faktur',
        'detbeli_kodebarcode',
        'detbeli_hargabeli',
        'detbeli_hargajual',
        'detbeli_jml',
        'detbeli_subtotal',
    ];
}
