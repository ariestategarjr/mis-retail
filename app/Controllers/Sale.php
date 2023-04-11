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

        $formatFakturCode = 'FS' . date('dmy', strtotime($date)) . sprintf('%04s', $nextOrderNumb);

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
            'nofaktur' => $this->generateFakturCode()
        ];

        return view('sales/input', $data);
    }

    public function saveTemp()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $codeBarcode = $this->request->getPost('codeBarcode');
            $nameProduct = $this->request->getPost('nameProduct');
            $amount = $this->request->getPost('amount');
            $noFaktur = $this->request->getPost('noFaktur');

            if (strlen($nameProduct) > 0) {
                $query = $this->db->table('produk')
                    ->where('kodebarcode', $codeBarcode)
                    ->where('namaproduk', $nameProduct)
                    ->get();
            } else {
                $query = $this->db->table('produk')
                    ->like('kodebarcode', $codeBarcode)
                    ->orlike('namaproduk', $codeBarcode)
                    ->get();
            }

            $result = $query->getNumRows();

            if ($result > 1) {
                $msg = [
                    'data' => 'many'
                ];
            } else if ($result == 1) {
                $tblTempSale = $this->db->table('temp_penjualan');

                $row = $query->getRowArray();

                if (intval($row['stok_tersedia']) == 0) {
                    $msg = [
                        'error' => 'Maaf, stok sudah habis.'
                    ];
                } else if (intval($row['stok_tersedia']) < $amount) {
                    $msg = [
                        'error' => 'Maaf, stok tidak mencukupi.'
                    ];
                } else {
                    $data = [
                        'detjual_id' => $id,
                        'detjual_faktur' => $noFaktur,
                        'detjual_kodebarcode' => $row['kodebarcode'],
                        'detjual_hargabeli' => $row['harga_beli'],
                        'detjual_hargajual' => $row['harga_jual'],
                        'detjual_jml' => $amount,
                        'detjual_subtotal' => floatval($row['harga_jual']) * $amount
                    ];

                    $tblTempSale->insert($data);

                    $msg = [
                        'success' => 'berhasil'
                    ];
                }
            } else {
                $msg = [
                    'error' => 'Data tidak ditemukan.'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function calculateTotalPay()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = $this->request->getPost('fakturcode');

            $query = $this->db->table('temp_penjualan')
                ->select('SUM(detjual_subtotal) as totalbayar')
                ->where('detjual_faktur', $fakturcode)
                ->get();

            $row = $query->getRowArray();

            $msg = [
                'data' => number_format($row['totalbayar'], 0, ",", ".")
            ];

            echo json_encode($msg);
        }
    }

    public function displaySaleDetail()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = $this->request->getVar('fakturcode');

            $tblTempSale = $this->db->table('temp_penjualan');
            $query = $tblTempSale
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

    public function deleteItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('idItem');

            $tblTempSale = $this->db->table('temp_penjualan');

            $tblTempSale->delete([
                'detjual_id' => $id
            ]);

            $msg = [
                'success' => 'Item berhasil dihapus.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus item gagal.');
        }
    }

    public function saveTransaction()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = $this->request->getPost('fakturcode');
            $datefaktur = $this->request->getPost('datefaktur');
            $customercode = $this->request->getPost('customercode');

            $tblTempSale = $this->db->table('temp_penjualan');
            $query = $tblTempSale->getWhere(['detjual_faktur' => $fakturcode]);

            $queryTotal = $this->db->table('temp_penjualan')
                ->select('SUM(detjual_subtotal) as totalbayar')
                ->where('detjual_faktur', $fakturcode)
                ->get();
            $rowTotal = $queryTotal->getRowArray();

            if ($query->getNumRows() > 0) {
                $data = [
                    'fakturcode' => $fakturcode,
                    'customercode' => $customercode,
                    'totalpayment' => $rowTotal['totalbayar']
                ];

                $msg = [
                    'data' => view('sales/data_payment', $data)
                ];
            } else {
                $msg = [
                    'error' => 'Transaksi belum ada.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function deleteTransaction()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('fakturcode');

            $tblTempSale = $this->db->table('temp_penjualan');
            $query = $tblTempSale->emptyTable();

            if ($query) {
                $msg = [
                    'success' => 'Transaksi berhasil dihapus.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function savePayment()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = $this->request->getPost('fakturcode');
            $customercode = $this->request->getPost('customercode');
            $totalbruto = $this->request->getPost('totalbruto');
            $totalnetto = str_replace(",", "", $this->request->getPost('totalnetto'));
            $disprecent = str_replace(",", "", $this->request->getPost('disprecent'));
            $discash = str_replace(",", "", $this->request->getPost('discash'));
            $amountmoney = str_replace(",", "", $this->request->getPost('amountmoney'));
            $restmoney = str_replace(",", "", $this->request->getPost('restmoney'));

            $tblSale = $this->db->table('penjualan');
            $tblTempSale = $this->db->table('temp_penjualan');
            $tblDetailSale = $this->db->table('penjualan_detail');

            // Insert Tabel Penjualan
            $dataPenjualan = [
                'jual_faktur' => $fakturcode,
                'jual_tgl' => date('Y-m-d H:i:s'),
                'jual_pelkode' => $customercode,
                'jual_dispersen' => $disprecent,
                'jual_disuang' => $discash,
                'jual_totalkotor' => $totalbruto,
                'jual_totalbersih' => $totalnetto,
                'jual_jmluang' => $amountmoney,
                'jual_sisauang' => $restmoney,
            ];
            $tblSale->insert($dataPenjualan);

            // Insert Tabel Detail Penjualan
            $dataTempSale = $tblTempSale->getWhere(['detjual_faktur' => $fakturcode]);

            $dataSaleDetail = [];
            foreach ($dataTempSale->getResultArray() as $row) {
                $dataSaleDetail[] = [
                    'detjual_id' => $row['detjual_id'],
                    'detjual_faktur' => $row['detjual_faktur'],
                    'detjual_kodebarcode' => $row['detjual_kodebarcode'],
                    'detjual_hargabeli' => $row['detjual_hargabeli'],
                    'detjual_hargajual' => $row['detjual_hargajual'],
                    'detjual_jml' => $row['detjual_jml'],
                    'detjual_subtotal' => $row['detjual_subtotal'],
                ];
            }
            $tblDetailSale->insertBatch($dataSaleDetail);

            // Hapus Tabel Temp Penjualan
            $tblTempSale->emptyTable();

            $msg = [
                'success' => 'berhasil'
            ];

            echo json_encode($msg);
        }
    }
}
