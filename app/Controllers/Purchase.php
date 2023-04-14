<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SuppliersDatatableModel;
use Config\Services;

class Purchase extends BaseController
{
    public function index()
    {
        return view('purchases/menu');
    }

    public function generateFakturCode()
    {
        // $date = $this->request->getPost('tanggal');
        $date = date('Y-m-d');
        $query = $this->db->query(
            "SELECT MAX(jual_faktur) AS nofaktur FROM penjualan
             WHERE DATE_FORMAT(jual_tgl, '%Y-%m-%d') = '$date'"
        );
        $result = $query->getRowArray();
        $data = $result['nofaktur'];

        $lastOrderNumb = substr($data, -4);
        $nextOrderNumb = intval($lastOrderNumb) + 1;

        $formatFakturCode = 'FP' . date('dmy', strtotime($date)) . sprintf('%04s', $nextOrderNumb);

        return $formatFakturCode;
    }

    public function getModalSupplier()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('purchases/data_supplier')
            ];

            echo json_encode($msg);
        }
    }

    public function getListDataSupplier()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $datatable = new SuppliersDatatableModel($request);

            if ($request->getMethod(true) === 'POST') {
                $lists = $datatable->getDatatables();
                $data = [];
                $no = $request->getPost('start');

                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->sup_kode;
                    $row[] = $list->sup_nama;
                    $row[] = $list->sup_alamat;
                    $row[] = $list->sup_telp;
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"selectSupplier(
                        '{$list->sup_kode}',
                        '{$list->sup_nama}')\">Pilih</button>";
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
            $keywordCode = $this->request->getPost('keywordCode');

            $request = Services::request();
            $datatable = new ProductsDatatableModel($request);

            if ($request->getMethod(true) === 'POST') {
                $lists = $datatable->getDatatables($keywordCode);
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
                    'recordsTotal' => $datatable->countAll($keywordCode),
                    'recordsFiltered' => $datatable->countFiltered($keywordCode),
                    'data' => $data
                ];

                echo json_encode($output);
            }
        }
    }

    public function input()
    {
        $data = [
            'kodebarcode' => $this->generateFakturCode()
        ];

        return view('purchases/input', $data);
    }

    public function displayPurchaseDetail()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = $this->request->getVar('fakturcode');

            $tblTempPurchase = $this->db->table('temp_pembelian');
            $query = $tblTempPurchase
                ->select(
                    'detbeli_id as id,
                    detbeli_kodebarcode as kode,
                    namaproduk,
                    detbeli_hargajual as hargajual,
                    detbeli_jml as jml,
                    detbeli_subtotal as subtotal'
                )->join(
                    'produk',
                    'detbeli_kodebarcode=kodebarcode'
                )->where(
                    'detbeli_faktur',
                    $fakturcode
                )->orderby(
                    'detbeli_id',
                    'asc'
                );

            $data = [
                'dataPurchaseDetail' => $query->get()
            ];

            $msg = [
                'data' => view('purchases/detail', $data)
            ];

            echo json_encode($msg);
        }
    }
}
