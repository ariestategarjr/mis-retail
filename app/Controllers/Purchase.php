<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SuppliersDatatableModel;
use App\Models\ProductsDatatableModel;
use App\Models\PurchasesModel;
use Config\Services;

class Purchase extends BaseController
{
    public function __construct()
    {
        $this->purchases = new PurchasesModel();
    }

    public function index()
    {
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

        return view('purchases/menu');
    }

    public function generateFakturCode()
    {
        // $date = $this->request->getPost('tanggal');
        $date = date('Y-m-d');
        $query = $this->db->query(
            "SELECT MAX(beli_faktur) AS nofaktur FROM pembelian
             WHERE DATE_FORMAT(beli_tgl, '%Y-%m-%d') = '$date'"
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
                'modal' => view('purchases/data_product', $data)
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
                    $row[] = number_format($list->harga_beli, 0, ',', '.');
                    $row[] = "<input type=\"number\" id=\"numberItems{$list->kodebarcode}\" value=\"1\">";
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
        $type = $this->db->query("SHOW COLUMNS FROM pembelian WHERE Field = 'beli_jenisbayar'")->getRowArray()['Type'];
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);

        $data = [
            'faktur' => $this->generateFakturCode(),
            'jenisbayar' => $enum
        ];

        return view('purchases/input', $data);
    }

    public function saveTemp()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getPost('id'));
            $codeBarcode = esc($this->request->getPost('codeBarcode'));
            $nameProduct = esc($this->request->getPost('nameProduct'));
            $amount = esc($this->request->getPost('amount'));
            $noFaktur = esc($this->request->getPost('noFaktur'));

            // jika produk ada di tabel produk
            if (strlen($nameProduct) > 0) {
                $query = $this->db->table('produk')
                    ->where('kodebarcode', $codeBarcode)
                    ->where('namaproduk', $nameProduct)
                    ->get();
            }
            // jika produk tidak ada di tabel produk
            else {
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
                $tblTempPurchase = $this->db->table('temp_pembelian');

                $row = $query->getRowArray();

                if (intval($row['stok_tersedia']) == 0) {
                    // $msg = [
                    //     'error' => 'Maaf, stok sudah habis.'
                    // ];
                    $data = [
                        'detbeli_id' => $id,
                        'detbeli_faktur' => $noFaktur,
                        'detbeli_kodebarcode' => $row['kodebarcode'],
                        'detbeli_hargabeli' => $row['harga_beli'],
                        'detbeli_hargajual' => $row['harga_jual'],
                        'detbeli_jml' => $amount,
                        'detbeli_subtotal' => floatval($row['harga_beli']) * $amount
                    ];

                    $tblTempPurchase->insert($data);

                    $msg = [
                        'success' => 'berhasil'
                    ];
                } else if (intval($row['stok_tersedia']) < $amount) {
                    // $msg = [
                    //     'error' => 'Maaf, stok tidak mencukupi.'
                    // ];
                    $data = [
                        'detbeli_id' => $id,
                        'detbeli_faktur' => $noFaktur,
                        'detbeli_kodebarcode' => $row['kodebarcode'],
                        'detbeli_hargabeli' => $row['harga_beli'],
                        'detbeli_hargajual' => $row['harga_jual'],
                        'detbeli_jml' => $amount,
                        'detbeli_subtotal' => floatval($row['harga_beli']) * $amount
                    ];

                    $tblTempPurchase->insert($data);

                    $msg = [
                        'success' => 'berhasil'
                    ];
                } else {
                    $data = [
                        'detbeli_id' => $id,
                        'detbeli_faktur' => $noFaktur,
                        'detbeli_kodebarcode' => $row['kodebarcode'],
                        'detbeli_hargabeli' => $row['harga_beli'],
                        'detbeli_hargajual' => $row['harga_jual'],
                        'detbeli_jml' => $amount,
                        'detbeli_subtotal' => floatval($row['harga_beli']) * $amount
                    ];

                    $tblTempPurchase->insert($data);

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
            $fakturcode = esc($this->request->getPost('fakturcode'));

            $query = $this->db->table('temp_pembelian')
                ->select('SUM(detbeli_subtotal) as totalbayar')
                ->where('detbeli_faktur', $fakturcode)
                ->get();

            $row = $query->getRowArray();

            $msg = [
                'data' => number_format($row['totalbayar'], 0, ",", ".")
            ];

            echo json_encode($msg);
        }
    }

    public function displayPurchaseDetail()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = esc($this->request->getVar('fakturcode'));

            $tblTempPurchase = $this->db->table('temp_pembelian');
            $query = $tblTempPurchase
                ->select(
                    'detbeli_id as id,
                    detbeli_kodebarcode as kode,
                    namaproduk,
                    detbeli_hargabeli as hargabeli,
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

    public function deleteItem()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idItem'));

            $tblTempPurchase = $this->db->table('temp_pembelian');

            $tblTempPurchase->delete([
                'detbeli_id' => $id
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
            $fakturcode = esc($this->request->getPost('fakturcode'));
            $datefaktur = esc($this->request->getPost('datefaktur'));
            $suppliercode = esc($this->request->getPost('suppliercode'));

            $tblTempPurchase = $this->db->table('temp_pembelian');
            $query = $tblTempPurchase->getWhere(['detbeli_faktur' => $fakturcode]);

            $queryTotal = $this->db->table('temp_pembelian')
                ->select('SUM(detbeli_subtotal) as totalbayar')
                ->where('detbeli_faktur', $fakturcode)
                ->get();
            $rowTotal = $queryTotal->getRowArray();

            if ($query->getNumRows() > 0) {
                $data = [
                    'fakturcode' => $fakturcode,
                    'suppliercode' => $suppliercode,
                    'totalpayment' => $rowTotal['totalbayar']
                ];

                $msg = [
                    'data' => view('purchases/data_payment', $data)
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
            $nofaktur = esc($this->request->getPost('fakturcode'));

            $tblTempSale = $this->db->table('temp_pembelian');
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
            $fakturcode = esc($this->request->getPost('fakturcode'));
            $suppliercode = esc($this->request->getPost('suppliercode'));
            $totalbruto = esc($this->request->getPost('totalbruto'));
            $totalnetto = esc(str_replace(",", "", $this->request->getPost('totalnetto')));
            $disprecent = esc(str_replace(",", "", $this->request->getPost('disprecent')));
            $discash = esc(str_replace(",", "", $this->request->getPost('discash')));
            $amountmoney = esc(str_replace(",", "", $this->request->getPost('amountmoney')));
            $restmoney = esc(str_replace(",", "", $this->request->getPost('restmoney')));

            $tblPurchase = $this->db->table('pembelian');
            $tblTempPurchase = $this->db->table('temp_pembelian');
            $tblDetailPurchase = $this->db->table('pembelian_detail');

            // Insert Tabel Pembelian
            $dataPembelian = [
                'beli_faktur' => $fakturcode,
                'beli_tgl' => date('Y-m-d H:i:s'),
                'beli_supkode' => $suppliercode,
                'beli_dispersen' => $disprecent,
                'beli_disuang' => $discash,
                'beli_totalkotor' => $totalbruto,
                'beli_totalbersih' => $totalnetto,
                'beli_jmluang' => $amountmoney,
                'beli_sisauang' => $restmoney,
            ];
            $tblPurchase->insert($dataPembelian);

            // Insert Tabel Detail Pembelian
            $dataTempPurchase = $tblTempPurchase->getWhere(['detbeli_faktur' => $fakturcode]);

            $dataPurchaseDetail = [];
            foreach ($dataTempPurchase->getResultArray() as $row) {
                $dataPurchaseDetail[] = [
                    'detbeli_id' => $row['detbeli_id'],
                    'detbeli_faktur' => $row['detbeli_faktur'],
                    'detbeli_kodebarcode' => $row['detbeli_kodebarcode'],
                    'detbeli_hargabeli' => $row['detbeli_hargabeli'],
                    'detbeli_hargabeli' => $row['detbeli_hargabeli'],
                    'detbeli_jml' => $row['detbeli_jml'],
                    'detbeli_subtotal' => $row['detbeli_subtotal'],
                ];
            }
            $tblDetailPurchase->insertBatch($dataPurchaseDetail);

            // Hapus Tabel Temp Penjualan
            $tblTempPurchase->emptyTable();

            $msg = [
                'success' => 'berhasil'
            ];

            echo json_encode($msg);
        }
    }

    public function report()
    {
        $periode_dari = esc($this->request->getVar('periode_dari'));
        $periode_ke = esc($this->request->getVar('periode_ke'));

        // Cek isi periode awal dan periode akhir 
        if (isset($periode_dari) && isset($periode_ke)) {
            // Filter * berdasarkan periode awal dan periode akhir 
            $periode_filter = $this->purchases
                ->join('pembelian', 'pembelian.beli_faktur=pembelian_detail.detbeli_faktur')
                ->join('produk', 'produk.kodebarcode=pembelian_detail.detbeli_kodebarcode')
                ->where("beli_tgl BETWEEN '" . $periode_dari . "' AND '" . $periode_ke . "'");
            // Total detbeli_subtotal berdasarkan beli_tgl awal dan beli_tgl akhir
            $resultTotal = $this->purchases
                ->query("SELECT SUM(detbeli_subtotal) AS total_jumlah
                             FROM pembelian_detail
                             JOIN pembelian ON pembelian_detail.detbeli_faktur = pembelian.beli_faktur
                             WHERE pembelian.beli_tgl >= '" . $periode_dari . "' AND pembelian.beli_tgl <= '" . $periode_ke . "'");
        } else {
            $periode_filter = $this->purchases
                ->join('pembelian', 'pembelian.beli_faktur=pembelian_detail.detbeli_faktur')
                ->join('produk', 'produk.kodebarcode=pembelian_detail.detbeli_kodebarcode');
            $resultTotal = $this->purchases
                ->query("SELECT SUM(detbeli_subtotal) AS total_jumlah
                             FROM pembelian_detail
                             JOIN pembelian ON pembelian_detail.detbeli_faktur = pembelian.beli_faktur");
        }



        $data = [
            'purchases' => $periode_filter->get()->getResultArray(),
            'purchasesTotal' => $resultTotal->getRowArray(),
        ];

        // echo "<pre>";
        // print_r($resultTotal->getRowArray());
        // echo "</pre>";
        // exit;

        return view('purchases/report', $data);
    }
}
