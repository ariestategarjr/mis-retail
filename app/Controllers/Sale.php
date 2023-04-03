<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Sale extends BaseController
{
    public function index()
    {
        return view('sales/data');
    }

    public function generateFakturCode()
    {
        $date = $this->request->getPost('date');
        $query = $this->db->query(
            "SELECT MAX(jual_faktur) AS nofaktur FROM penjualan
             WHERE DATE_FORMAT(jual_tgl, '%Y-%m-%d') = '$date'"
        );
        $result = $query->getRowArray();
        $data = $result['nofaktur'];

        $lastOrderNumb = substr($data, -4);
        $nextOrderNumb = intval($lastOrderNumb) + 1;

        $formatFakturCode = 'FK' . date('dmy', strtotime($date)) . sprintf('%04s', $nextOrderNumb);

        $msg = [
            'fakturcode' => $formatFakturCode
        ];

        echo json_encode($msg);
    }

    public function displaySaleDetail()
    {
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

    public function input()
    {
        return view('sales/input');
    }
}
