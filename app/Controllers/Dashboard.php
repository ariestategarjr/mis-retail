<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use CodeIgniter\Database\Query;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->products = new ProductsModel();
    }

    public function index()
    {
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

        $queryProductsEmptyStock = "SELECT namaproduk FROM produk
            WHERE stok_tersedia = 0";
        $resultProductsEmptyStock = $this->products->query($queryProductsEmptyStock);

        $queryBestSellers = "SELECT namaproduk, harga_jual, SUM(detjual_jml) AS TotalPenjualan
            FROM penjualan_detail
            JOIN produk ON penjualan_detail.detjual_kodebarcode = produk.kodebarcode
            GROUP BY detjual_kodebarcode
            ORDER BY TotalPenjualan DESC
            LIMIT 10
        ";
        $resultBestSellers = $this->products->query($queryBestSellers);

        $db = \Config\Database::connect();
        $data = [
            'count_products' => $this->products->countAll(),
            'count_sales' => $db->table('penjualan')->countAll(),
            'count_purchases' => $db->table('pembelian')->countAll(),
            'empty_stock' => $resultProductsEmptyStock->getResultArray(),
            'best_sellers' => $resultBestSellers->getResultArray(),
        ];


        // echo "<pre>";
        // foreach ($data['best_sellers'] as $row) :
        //     var_dump($row);
        // endforeach;
        // echo "</pre>";
        // exit;


        return view('dashboard', $data);
    }
}
