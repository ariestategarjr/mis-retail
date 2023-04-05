<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsDatatableModel;
use Config\Services;

class Sale extends BaseController
{
    public function index()
    {
        return view('sales/menu');
    }

    public function generateFakturCode()
    {
        $date = $this->request->getPost('tanggal');
        $query = $this->db->query(
            "SELECT MAX(jual_faktur) AS nofaktur FROM penjualan
             WHERE DATE_FORMAT(jual_tgl, '%Y-%m-%d') = '$date'"
        );
        $result = $query->getRowArray();
        $data = $result['nofaktur'];

        $lastOrderNumb = substr($data, -4);
        $nextOrderNumb = intval($lastOrderNumb) + 1;

        $formatFakturCode = 'FK' . date('dmy', strtotime($date)) . sprintf('%04s', $nextOrderNumb);

        return $formatFakturCode;
    }

    public function getModalProduct()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');

            $data = [
                'keyword' => $keyword
            ];

            $msg = [
                'modal' => view('sales/data_product', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function getListDataProduct()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $datatable = new ProductsDatatableModel($request);

            if ($request->getMethod(true) === 'POST') {
                $lists = $datatable->getDatatables();
                $data = [];
                $no = $request->getPost('start');

                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->kodebarcode;
                    $row[] = $list->namaproduk;
                    $row[] = $list->katnama;
                    $row[] = number_format($list->stok_tersedia, 0, ',', '.');
                    $row[] = number_format($list->harga_jual, 0, ',', '.');
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"selectProduct(
                              '{$list->kodebarcode}',
                              '{$list->namaproduk}')\">Pilih</button>";
                    $data[] = $row;
                }

                $output = [
                    'draw' => $request->getPost('draw'),
                    'recordsTotal' => $datatable->countAll(),
                    'recordsFiltered' => $datatable->countFiltered(),
                    'data' => $data
                ];

                echo json_encode($output);
            }
        }
    }

    public function input()
    {
        $data = [
            'nofaktur' => $this->generateFakturCode()
        ];

        return view('sales/input', $data);
    }

    public function saveTemp()
    {
        if ($this->request->isAJAX()) {
            $codeBarcode = $this->request->getPost('codeBarcode');
            $nameProduct = $this->request->getPost('nameProduct');
            $amount = $this->request->getPost('amount');
            $noFaktur = $this->request->getPost('noFaktur');

            $query = $this->db->table('produk')
                ->like('kodebarcode', $codeBarcode)
                ->orlike('namaproduk', $codeBarcode)
                ->get();

            $result = $query->getNumRows();

            if ($result > 1) {
                $msg = [
                    'data' => 'many'
                ];
            } else {
                $msg = [
                    'data' => 'one'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function displaySaleDetail()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = $this->request->getVar('fakturcode');

            $tempSale = $this->db->table('temp_penjualan');
            $query = $tempSale
                ->select(
                    'detjual_id as id,
                    detjual_kodebarcode as kode,
                    namaproduk,
                    detjual_hargajual as hargajual,
                    detjual_jml as jml,
                    detjual_subtotal as subtotal'
                )->join(
                    'produk',
                    'detjual_kodebarcode=kodebarcode'
                )->where(
                    'detjual_faktur',
                    $fakturcode
                )->orderby(
                    'detjual_id',
                    'asc'
                );

            $data = [
                'dataSaleDetail' => $query->get()
            ];

            $msg = [
                'data' => view('sales/detail', $data)
            ];

            echo json_encode($msg);
        }
    }
}
