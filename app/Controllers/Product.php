<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use App\Models\UnitsModel;

class Product extends BaseController
{
    public function __construct()
    {
        $this->products = new ProductsModel();
        $this->categories = new CategoriesModel();
        $this->units = new UnitsModel();
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

    public function addFormProduct()
    {
        return view('products/add');
    }

    public function getAllCategories()
    {
        if ($this->request->isAJAX()) {
            $data = $this->categories->orderby('katnama', 'asc')->findall();

            $optionElement = "<option value='' selected>-Pilih-</option>";

            foreach ($data as $row) :
                $optionElement .= "<option value='{$row['katid']}'>{$row['katnama']}</option>";
            endforeach;

            $msg = [
                'data' => $optionElement
            ];
            echo json_encode($msg);
        }
    }

    public function getAllUnits()
    {
        if ($this->request->isAJAX()) {
            $data = $this->units->orderby('satnama', 'asc')->findall();

            $optionElement = "<option value='' selected>-Pilih-</option>";

            foreach ($data as $row) :
                $optionElement .= "<option value='{$row['satid']}'>{$row['satnama']}</option>";
            endforeach;

            $msg = [
                'data' => $optionElement
            ];
            echo json_encode($msg);
        }
    }
}
