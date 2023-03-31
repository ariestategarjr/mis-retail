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

    public function addProduct()
    {
        if ($this->request->isAJAX()) {
            $codeBarcode = $this->request->getVar('codeBarcode');
            $nameProduct = $this->request->getVar('nameProduct');
            $stockProduct = str_replace(',', '', $this->request->getVar('stockProduct'));
            $unitProduct = $this->request->getVar('unitProduct');
            $categoryProduct = $this->request->getVar('categoryProduct');
            $purchasePrice = str_replace(',', '', $this->request->getVar('purchasePrice'));
            $sellingPrice = str_replace(',', '', $this->request->getVar('sellingPrice'));

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
                        'errorUnitProduct' => $validation->getError('unitProduct'),
                        'errorCategoryProduct' => $validation->getError('categoryProduct'),
                        'errorImageUpload' => $validation->getError('imageUpload')
                    ]
                ];
            } else {
                $fileImageUpload = $_FILES['imageUpload']['name'];

                if ($fileImageUpload != NULL) {
                    $nameImageUpload = "$codeBarcode-$nameProduct";
                    $fileImage = $this->request->getFile('imageUpload');
                    $fileImage->move('assets/upload' . $nameImageUpload . '.' . $fileImage->getExtension());

                    $pathImage = '.assets/upload/' . $fileImage->getName();
                } else {
                    $pathImage = '';
                }

                $this->products->insert([
                    'kodebarcode' => $codeBarcode,
                    'namaproduk' => $nameProduct,
                    'produk_satid' => $unitProduct,
                    'produk_katid' => $categoryProduct,
                    'stok_tersedia' => $stockProduct,
                    'hargabeli' => $purchasePrice,
                    'hargajual' => $sellingPrice,
                    'gambar' => $pathImage
                ]);

                $msg = [
                    'success' => 'Produk berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
            // echo json_encode($msg);

            // dd(json_encode($msg));
        }
    }
}
