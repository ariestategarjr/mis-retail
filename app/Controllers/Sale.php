<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsDatatableModel;
use App\Models\CustomersDatatableModel;
use App\Models\SalesModel;
use Config\Services;
use PhpParser\Node\Expr\Isset_;

class Sale extends BaseController
{
    public function __construct()
    {
        $this->sales = new SalesModel();
    }

    public function index()
    {
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

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

    public function getModalCustomer()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('sales/data_customer')
            ];

            echo json_encode($msg);
        }
    }

    public function getListDataCustomer()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $datatable = new CustomersDatatableModel($request);

            if ($request->getMethod(true) === 'POST') {
                $lists = $datatable->getDatatables();
                $data = [];
                $no = $request->getPost('start');

                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->pel_kode;
                    $row[] = $list->pel_nama;
                    $row[] = $list->pel_alamat;
                    $row[] = $list->pel_telp;
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"selectCustomer(
                        '{$list->pel_kode}',
                        '{$list->pel_nama}')\">Pilih</button>";
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
        $data = [
            'nofaktur' => $this->generateFakturCode()
        ];

        return view('sales/input', $data);
    }

    public function saveTemp()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getPost('id'));
            $codeBarcode = esc($this->request->getPost('codeBarcode'));
            $nameProduct = esc($this->request->getPost('nameProduct'));
            $amount = esc($this->request->getPost('amount'));
            $noFaktur = esc($this->request->getPost('noFaktur'));

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

            // echo "<pre>";
            // die($result);
            // echo "</pre>";

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
            $fakturcode = esc($this->request->getPost('fakturcode'));

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
            $fakturcode = esc($this->request->getVar('fakturcode'));

            $tblTempSale = $this->db->table('temp_penjualan');
            $tblSale = $this->db->table('penjualan');

            $queryDetjual = $tblTempSale
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

            // echo "<pre>";
            // var_dump($fakturcode);
            // echo "</pre>";
            // $query = $this->db->query(
            //     "SELECT * FROM penjualan "
            // );

            $queryJual = $tblSale
                ->select(
                    'jual_tgl',
                    'jual_pelkode',
                    'jual_dispersen',
                    'jual_disuang',
                    'jual_totalkotor',
                    'jual_totalbersih',
                    'jual_jmluang',
                    'jual_sisauang'
                )->where(
                    'jual_faktur',
                    $fakturcode
                );

            // $query = $this->db->table('penjualan')->select(
            //     'jual_tgl',


            //     'jual_jmluang',
            //     'jual_sisauang'
            // )
            //     ->get()->getResult();

            // echo "<pre>";
            // print_r($queryDetjual->get()->getResult());
            // echo "</pre>";

            $data = [
                'dataSaleDetail' => $queryDetjual->get(),
                // 'dataSale' => $queryJual->get(),
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
            $id = esc($this->request->getVar('idItem'));

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

    // Tombol Simpan Transaksi
    public function processTransaction()
    {
        if ($this->request->isAJAX()) {
            $fakturcode = esc($this->request->getPost('fakturcode'));
            $datefaktur = esc($this->request->getPost('datefaktur'));
            $customercode = esc($this->request->getPost('customercode'));

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

    // Tombol Hapus Transaksi
    public function deleteTransaction()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = esc($this->request->getPost('fakturcode'));

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
            $fakturcode = esc($this->request->getPost('fakturcode'));
            $customercode = esc($this->request->getPost('customercode'));
            $totalbruto = esc($this->request->getPost('totalbruto'));
            $totalnetto = esc(str_replace(",", "", $this->request->getPost('totalnetto')));
            $disprecent = esc(str_replace(",", "", $this->request->getPost('disprecent')));
            $discash = esc(str_replace(",", "", $this->request->getPost('discash')));
            $amountmoney = esc(str_replace(",", "", $this->request->getPost('amountmoney')));
            $restmoney = esc(str_replace(",", "", $this->request->getPost('restmoney')));

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
                'success' => 'berhasil',
            ];

            echo json_encode($msg);
        }
    }

    // public function getInvoice()
    // {
    //     $fakturcode = esc($this->request->getVar('fakturcode'));

    //     // $tblTempSale = $this->db->table('temp_penjualan');
    //     // $tblSale = $this->db->table('penjualan');

    //     // $queryDetjual = $tblTempSale
    //     //     ->select(
    //     //         'detjual_id as id,
    //     //         detjual_kodebarcode as kode,
    //     //         namaproduk,
    //     //         detjual_hargajual as hargajual,
    //     //         detjual_jml as jml,
    //     //         detjual_subtotal as subtotal'
    //     //     )->join(
    //     //         'produk',
    //     //         'detjual_kodebarcode=kodebarcode'
    //     //     )->where(
    //     //         'detjual_faktur',
    //     //         $fakturcode
    //     //     )->orderby(
    //     //         'detjual_id',
    //     //         'asc'
    //     //     )->get()->getResultArray();

    //     $data = [
    //         'dataSaleDetail' => $fakturcode,
    //     ];

    //     $msg = [
    //         'data' => view('sales/data_payment', $data)

    //     ];

    //     echo json_encode($msg);

    //     // $saleInvoice = $this->sales
    //     //     ->join('penjualan', 'penjualan.jual_faktur=penjualan_detail.detjual_faktur')
    //     //     ->where("detjual_faktur='" . $fakturcode);
    // }

    public function report()
    {
        $periode_dari = esc($this->request->getVar('periode_dari'));
        $periode_ke = esc($this->request->getVar('periode_ke'));

        // Cek isi periode awal dan periode akhir 
        if (isset($periode_dari) && isset($periode_ke)) {
            // Filter * berdasarkan periode awal dan periode akhir 
            $periode_filter = $this->sales
                ->join('penjualan', 'penjualan.jual_faktur=penjualan_detail.detjual_faktur')
                ->join('produk', 'produk.kodebarcode=penjualan_detail.detjual_kodebarcode')
                ->where("jual_tgl BETWEEN '" . $periode_dari . "' AND '" . $periode_ke . "'");
            // Total detjual_subtotal berdasarkan jual_tgl awal dan jual_tgl akhir
            $resultTotal = $this->sales
                ->query("SELECT SUM(detjual_subtotal) AS total_jumlah
                         FROM penjualan_detail
                         JOIN penjualan ON penjualan_detail.detjual_faktur = penjualan.jual_faktur
                         WHERE penjualan.jual_tgl >= '" . $periode_dari . "' AND penjualan.jual_tgl <= '" . $periode_ke . "'");
        } else {
            $periode_filter = $this->sales
                ->join('penjualan', 'penjualan.jual_faktur=penjualan_detail.detjual_faktur')
                ->join('produk', 'produk.kodebarcode=penjualan_detail.detjual_kodebarcode');
            $resultTotal = $this->sales
                ->query("SELECT SUM(detjual_subtotal) AS total_jumlah
                         FROM penjualan_detail
                         JOIN penjualan ON penjualan_detail.detjual_faktur = penjualan.jual_faktur");
        }

        $data = [
            'sales' => $periode_filter->get()->getResultArray(),
            'salesTotal' => $resultTotal->getRowArray(),
        ];

        return view('sales/report', $data);
    }

    public function deleteFilter()
    {
        $periode_dari = esc($this->request->getPost('periodedari'));
        $periode_ke = esc($this->request->getPost('periodeke'));

        if (!isset($periode_dari) && !isset($periode_ke)) {
            die('error');
        }

        $result = $this->sales->deleteDataByDateRange($periode_dari, $periode_ke);
    }
















    // $db = \Config\Database::connect(); // Menghubungkan ke database

    // Get the MySQLi connection object
    // $mysqliConnection = $db->connID;

    // Convert the MySQLi connection to a string representation
    // $connectionString = (string) $mysqliConnection;

    // $this->sale->select('pjd.*, pj.*');
    // $this->sale->from('penjualan_det AS pjd');
    // $this->sale->join('nama_tabel2 AS pj', 'pjd.id = pj.id');
    // $this->sale->where("pjd.tanggal_awal >= '$startDate' AND pjd.tanggal_akhir <= '$endDate'");
    // $this->sale->where("pj.tanggal_awal >= '$startDate' AND pj.tanggal_akhir <= '$endDate'");
    // $this->sale->delete('penjualan_det AS pjd');

    // echo "<pre>";
    // var_dump($result1);
    // echo "</pre>";
    // exit;

    // $result1 = $db->table('penjualan_detail')
    //     ->join('penjualan', 'penjualan_detail.detjual_faktur = penjualan.jual_faktur')
    //     ->where('jual_tgl >', $periode_dari)
    //     ->where('jual_tgl <', $periode_ke)
    //     ->delete();

    // $result2 = $db->table('penjualan')
    //     ->where('jual_tgl', [$periode_dari, $periode_ke])
    //     ->delete();

    // if ($result1 && $result2) {
    //     $msg = [
    //         'success' => 'Data berhasil dihapus'
    //     ];
    // }
    // echo json_encode($msg);

    // 'sales' => $this->sales
    //     ->join('penjualan', 'penjualan.jual_faktur=penjualan_detail.detjual_faktur')
    //     ->join('produk', 'produk.kodebarcode=penjualan_detail.detjual_kodebarcode')
    //     ->get()->getResultArray(),
    // 'sales' => (isset($periode_dari) && isset($periode_ke)) ? $this->sales->findAll() : $this->sales
    //     ->where('jual_tgl >=', $periode_ke)
    //     ->where('jual_tgl <=', $periode_ke)
    //     ->get()->getResult(),
    // 'sales' => $this->sales->findAll(),
    // 'sales' => $this->sales->join('penjualan_detail', 'penjualan_detail.')
    // 'sales_totalkotor' => $this->sales
    //     ->selectsum('jual_totalkotor', 'sum_jual_totalkotor')
    //     ->get()->getRow()
    //     ->sum_jual_totalkotor,
    // 'sales_totalbersih' => $this->sales
    //     ->selectsum('jual_totalbersih', 'sum_jual_totalbersih')
    //     ->get()->getRow()
    //     ->sum_jual_totalbersih,
}
