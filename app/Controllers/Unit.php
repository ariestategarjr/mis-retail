<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnitsModel;

class Unit extends BaseController
{
    public function __construct()
    {
        $this->units = new UnitsModel();
    }

    public function index()
    {
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

        $data = [
            'units' => $this->units->orderby('satnama', 'asc')->findAll()
        ];

        return view('units/data', $data);
    }

    public function addModalUnit()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'reload' => $this->request->getPost('reload')
            ];

            $msg = [
                'data' => view('units/add', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, halaman tidak dapat ditampilkan.');
        }
    }

    public function editModalUnit()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idUnit'));
            $name = esc($this->request->getVar('namaUnit'));

            $data = [
                'idUnit' => $id,
                'nameUnit' => $name
            ];

            $msg = [
                'data' => view('units/edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, halaman tidak dapat ditampilkan');
        }
    }

    public function addUnit()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idUnit'));
            $name = esc($this->request->getVar('nameUnit'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                'idUnit' => [
                    'label' => 'Kode Satuan',
                    'rules' => 'required|is_unique[satuan.satid]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ],
                'nameUnit' => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required|is_unique[satuan.satnama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'errorIdUnit' => $validation->getError('idUnit'),
                        'errorNameUnit' => $validation->getError('nameUnit'),
                    ]
                ];
            } else {
                $this->units->insert([
                    'satid' => $id,
                    'satnama' => $name
                ]);

                $msg = [
                    'success' => 'Satuan berhasil ditambahkan.'
                ];
            }

            echo json_encode($msg);
        } else {
            exit('Maaf, tambah satuan gagal.');
        }
    }

    public function editUnit()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idUnit'));
            $name = esc($this->request->getVar('nameUnit'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                // 'idUnit' => [
                //     'label' => 'Kode Satuan',
                //     'rules' => 'required|is_unique[satuan.satid]',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //         'is_unique' => '{field} sudah ada, coba yang lain'
                //     ]
                // ],
                'nameUnit' => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required|is_unique[satuan.satnama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        // 'errorIdUnit' => $validation->getError('idUnit'),
                        'errorNameUnit' => $validation->getError('nameUnit'),
                    ]
                ];
            } else {
                $this->units->update($id, [
                    'satnama' => $name
                ]);

                $msg = [
                    'success' => 'Satuan berhasil diedit.'
                ];
            }

            echo json_encode($msg);
        } else {
            exit('Maaf, edit satuan gagal.');
        }
    }

    public function deleteUnit()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idUnit'));

            $this->units->delete([
                'satid' => $id
            ]);

            $msg = [
                'success' => 'Satuan berhasil dihapus.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus satuan gagal.');
        }
    }
}
