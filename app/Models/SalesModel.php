<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;
// use CodeIgniter\Database\Query;

class SalesModel extends Model
{
    protected $table            = 'penjualan_detail';
    protected $primaryKey       = 'detjual_id';
    protected $allowedFields    = [
        'detjual_id',
        'detjual_faktur',
        'detjual_kodebarcode',
        'detjual_hargabeli',
        'detjual_hargajual',
        'detjual_jml',
        'detjual_subtotal',
    ];

    public function totalSubTotal()
    {
        $this->table = 'penjualan_detail';
    }

    public function deleteDataByDateRange($startDate, $endDate)
    {
        $this->table = 'penjualan_detail';

        $this->query("DELETE pjd
            FROM penjualan_detail AS pjd
            JOIN penjualan AS pj ON pjd.detjual_faktur = pj.jual_faktur
            WHERE pj.jual_tgl BETWEEN '" . $startDate . "' AND '" . $endDate . "'");

        $this->query("DELETE pj
            FROM penjualan AS pj
            WHERE jual_tgl BETWEEN '" . $startDate . "' AND '" . $endDate . "'");



        // $this->join('penjualan', 'penjualan.jual_faktur = penjualan_detail.detjual_faktur');
        // $this->where('penjualan.jual_tgl <= 2023-06-10 AND penjualan.jual_tgl >= 2023-06-08');
        // $this->delete();

        // echo "<pre>";
        // print_r($startDate);
        // echo "</pre>";
        // exit;
    }
}
