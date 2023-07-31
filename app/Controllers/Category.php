<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;

class Category extends BaseController
{
    public function __construct()
    {
        $this->categories = new CategoriesModel();
    }

    public function index()
    {
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

        $data = [
            'categories' => $this->categories->orderby('katnama', 'asc')->findAll()
        ];

        return view('categories/data', $data);
    }

    public function addModalCategory()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'reload' => $this->request->getPost('reload')
            ];
            $msg = [
                'data' => view('categories/add', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, halaman tidak dapat ditampilkan.');
        }
    }

    public function editModalCategory()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idCategory'));
            $name = esc($this->request->getVar('nameCategory'));

            $data = array(
                'idCategory' => $id,
                'nameCategory' => $name
            );

            $msg = [
                'data' => view('categories/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function addCategory()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idCategory'));
            $name = esc($this->request->getVar('nameCategory'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                'idCategory' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required|is_unique[kategori.katid]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ],
                'nameCategory' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required|is_unique[kategori.katnama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        // 'errorIdCategory' => $validation->getError('idCategory'),
                        'errorNameCategory' => $validation->getError('nameCategory'),
                    ]
                ];
            } else {
                $this->categories->insert([
                    'katid' => $id,
                    'katnama' => $name
                ]);

                $msg = [
                    'success' => 'Kategori berhasil ditambahkan.'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, tambah kategori gagal.');
        }
    }

    public function editCategory()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idCategory'));
            $name = esc($this->request->getVar('nameCategory'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                // 'idCategory' => [
                //     'label' => 'Kode Kategori',
                //     'rules' => 'required|is_unique[kategori.katid]',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //         'is_unique' => '{field} sudah ada, coba yang lain'
                //     ]
                // ],
                'nameCategory' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required|is_unique[kategori.katnama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        // 'errorIdCategory' => $validation->getError('idCategory'),
                        'errorNameCategory' => $validation->getError('nameCategory'),
                    ]
                ];
            } else {
                $this->categories->update($id, [
                    'katnama' => $name
                ]);

                $msg = [
                    'success' => 'Kategori berhasil diedit.'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf, edit kategori gagal.');
        }
    }

    public function deleteCategory()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idCategory'));

            $this->categories->delete([
                'katid' => $id
            ]);

            $msg = [
                'success' => 'Kategori berhasil dihapus.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus kategori gagal.');
        }
    }
}
