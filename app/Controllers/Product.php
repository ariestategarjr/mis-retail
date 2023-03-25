<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;

class Product extends BaseController
{
    public function __construct()
    {
        $this->products = new ProductsModel();
    }

    public function index()
    {
        $data = [
            'products' => $this->products
                ->orderby('namaproduk', 'asc')
                ->join('satuan', 'satuan.satid=produk.produk_satid')
                ->join('kategori', 'kategori.katid=produk.produk_katid')
                ->findall()
        ];

        return view('products/data', $data);
    }

    public function addFormPage()
    {
        return view('products/add');
    }
}
