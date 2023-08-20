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
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

        $data = [
            'products' => $this->products
                ->orderby('namaproduk', 'asc')
                ->join('satuan', 'satuan.satid=produk.produk_satid')
                ->join('kategori', 'kategori.katid=produk.produk_katid')
                ->findall()
        ];

        return view('products/data', $data);
    }

    public function add()
    {
        return view('products/add');
    }

    public function edit($code)
    {
        $row = $this->products->find($code);

        if ($row) {
            $data = [
                'codeBarcode' => $row['kodebarcode'],
                'nameProduct' => $row['namaproduk'],
                'stockProduct' => $row['stok_tersedia'],
                'unitProduct' => $row['produk_satid'],
                'unitData' => $this->units->findAll(),
                'categoryProduct' => $row['produk_katid'],
                'categoryData' => $this->categories->findAll(),
                'purchasePrice' => $row['harga_beli'],
                'sellingPrice' => $row['harga_jual'],
                'imageUpload' => $row['gambar']
            ];
            return view('products/edit', $data);
        } else {
            exit('Data tidak ditemukan.');
        }

        return view('products/edit');
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

    public function addProduct()
    {
        if ($this->request->isAJAX()) {
            $codeBarcode = esc($this->request->getVar('codeBarcode'));
            $nameProduct = esc($this->request->getVar('nameProduct'));
            $stockProduct = esc(str_replace(',', '', $this->request->getVar('stockProduct')));
            $unitProduct = esc($this->request->getVar('unitProduct'));
            $categoryProduct = esc($this->request->getVar('categoryProduct'));
            $purchasePrice = esc(str_replace(',', '', $this->request->getVar('purchasePrice')));
            $sellingPrice = esc(str_replace(',', '', $this->request->getVar('sellingPrice')));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                'codeBarcode' => [
                    'label' => 'Kode Barcode',
                    'rules' => 'required|is_unique[produk.kodebarcode]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ],
                'nameProduct' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required|is_unique[produk.namaproduk]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
                'stockProduct' => [
                    'label' => 'Stok',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'unitProduct' => [
                    'label' => 'Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'categoryProduct' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'purchasePrice' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'sellingPrice' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'imageUpload' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[imageUpload,image/png,image/jpg,image/jpeg]|ext_in[imageUpload,png,jpg,jpeg]|is_image[imageUpload]',
                    'errors' => [
                        'mime_in' => '{field} hanya berformat png, jpg, jpeg',
                        'ext_in' => '{field} hanya berformat png, jpg, jpeg',
                        'is_image' => '{field} hanya berformat png, jpg, jpeg'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'errorCodeBarcode' => $validation->getError('codeBarcode'),
                        'errorNameProduct' => $validation->getError('nameProduct'),
                        'errorStockProduct' => $validation->getError('stockProduct'),
                        'errorUnitProduct' => $validation->getError('unitProduct'),
                        'errorCategoryProduct' => $validation->getError('categoryProduct'),
                        'errorPurchasePrice' => $validation->getError('purchasePrice'),
                        'errorSellingPrice' => $validation->getError('sellingPrice'),
                        'errorImageUpload' => $validation->getError('imageUpload')
                    ]
                ];
            } else {
                $fileImageUpload = $_FILES['imageUpload']['name'];

                if ($fileImageUpload != NULL) {
                    $nameImageUpload = "$codeBarcode-$nameProduct";
                    $fileImage = $this->request->getFile('imageUpload');
                    $fileImage->move('assets/upload', $nameImageUpload . '.' . $fileImage->getExtension());

                    $pathImage = 'assets/upload/' . $fileImage->getName();
                } else {
                    $pathImage = '';
                }

                $this->products->insert([
                    'kodebarcode' => $codeBarcode,
                    'namaproduk' => $nameProduct,
                    'produk_satid' => $unitProduct,
                    'produk_katid' => $categoryProduct,
                    'stok_tersedia' => $stockProduct,
                    'harga_beli' => $purchasePrice,
                    'harga_jual' => $sellingPrice,
                    'gambar' => $pathImage
                ]);

                $msg = [
                    'success' => 'Produk berhasil ditambahkan.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function editProduct()
    {
        if ($this->request->isAJAX()) {
            $codeBarcode = esc($this->request->getVar('codeBarcode'));
            $nameProduct = esc($this->request->getVar('nameProduct'));
            $stockProduct = esc(str_replace(',', '', $this->request->getVar('stockProduct')));
            $unitProduct = esc($this->request->getVar('unitProduct'));
            $categoryProduct = esc($this->request->getVar('categoryProduct'));
            $purchasePrice = esc(str_replace(',', '', $this->request->getVar('purchasePrice')));
            $sellingPrice = esc(str_replace(',', '', $this->request->getVar('sellingPrice')));

            $validation = \Config\Services::validation();

            // $validate = $this->validate([
            //     'nameProduct' => [
            //         'label' => 'Nama Produk',
            //         'rules' => 'required',
            //         'errors' => [
            //             'required' => '{field} tidak boleh kosong'
            //         ]
            //     ],
            //     'imageUpload' => [
            //         'label' => 'Upload Gambar',
            //         'rules' => 'mime_in[imageUpload,image/png,image/jpg,image/jpeg]|ext_in[imageUpload,png,jpg,jpeg]|is_image[imageUpload]',
            //         'errors' => [
            //             'mime_in' => '{field} hanya berformat png, jpg, jpeg',
            //             'ext_in' => '{field} hanya berformat png, jpg, jpeg',
            //             'is_image' => '{field} hanya berformat png, jpg, jpeg'
            //         ]
            //     ]
            // ]);

            $validate = $this->validate([
                // 'codeBarcode' => [
                //     'label' => 'Kode Barcode',
                //     'rules' => 'required|is_unique[produk.kodebarcode]',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //         'is_unique' => '{field} sudah ada, coba yang lain'
                //     ]
                // ],
                'nameProduct' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'stockProduct' => [
                    'label' => 'Stok',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'unitProduct' => [
                    'label' => 'Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'categoryProduct' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'purchasePrice' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'sellingPrice' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'imageUpload' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[imageUpload,image/png,image/jpg,image/jpeg]|ext_in[imageUpload,png,jpg,jpeg]|is_image[imageUpload]',
                    'errors' => [
                        'mime_in' => '{field} hanya berformat png, jpg, jpeg',
                        'ext_in' => '{field} hanya berformat png, jpg, jpeg',
                        'is_image' => '{field} hanya berformat png, jpg, jpeg'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    // 'error' => [
                    //     'errorNameProduct' => $validation->getError('nameProduct'),
                    //     'errorImageUpload' => $validation->getError('imageUpload')
                    // ]
                    'error' => [
                        // 'errorCodeBarcode' => $validation->getError('codeBarcode'),
                        'errorNameProduct' => $validation->getError('nameProduct'),
                        'errorStockProduct' => $validation->getError('stockProduct'),
                        'errorUnitProduct' => $validation->getError('unitProduct'),
                        'errorCategoryProduct' => $validation->getError('categoryProduct'),
                        'errorPurchasePrice' => $validation->getError('purchasePrice'),
                        'errorSellingPrice' => $validation->getError('sellingPrice'),
                        'errorImageUpload' => $validation->getError('imageUpload')
                    ]
                ];
            } else {
                $fileImageUpload = $_FILES['imageUpload']['name'];

                $rowDataProduct = $this->products->find($codeBarcode);

                if ($fileImageUpload != NULL) {
                    unlink($rowDataProduct['gambar']);
                    $nameImageUpload = "$codeBarcode-$nameProduct";
                    $fileImage = $this->request->getFile('imageUpload');
                    $fileImage->move('assets/upload', $nameImageUpload . '.' . $fileImage->getExtension());

                    $pathImage = 'assets/upload/' . $fileImage->getName();
                } else {
                    $pathImage = $rowDataProduct['gambar'];
                }

                $this->products->update($codeBarcode, [
                    'namaproduk' => $nameProduct,
                    'produk_satid' => $unitProduct,
                    'produk_katid' => $categoryProduct,
                    'stok_tersedia' => $stockProduct,
                    'harga_beli' => $purchasePrice,
                    'harga_jual' => $sellingPrice,
                    'gambar' => $pathImage
                ]);

                $msg = [
                    'success' => 'Produk berhasil diperbarui.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function deleteProduct()
    {
        if ($this->request->isAJAX()) {
            $code = esc($this->request->getVar('codeProduct'));

            $this->products->delete([
                'kodebarcode' => $code
            ]);

            $msg = [
                'success' => 'Produk berhasil dihapus.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus produk gagal.');
        }
    }
}
