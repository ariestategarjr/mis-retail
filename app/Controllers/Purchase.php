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

    public function input()
    {
        $data = [
            'kodebarcode' => $this->generateFakturCode()
        ];

        return view('purchases/input', $data);
    }
}
