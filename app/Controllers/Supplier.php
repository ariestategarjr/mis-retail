<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SuppliersModel;

class Supplier extends BaseController
{
    public function __construct()
    {
        $this->suppliers = new SuppliersModel();
    }

    public function index()
    {
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

        $data = [
            'suppliers' => $this->suppliers->orderby('sup_nama', 'asc')->findAll()
        ];

        return view('suppliers/data', $data);
    }

    public function add()
    {
        return view('suppliers/add');
    }

    public function edit($id)
    {
        $row = $this->suppliers->find($id);

        if ($row) {
            $data = [
                'idSupplier' => $row['sup_kode'],
                'nameSupplier' => $row['sup_nama'],
                'addressSupplier' => $row['sup_alamat'],
                'telpSupplier' => $row['sup_telp']
            ];
            return view('suppliers/edit', $data);
        } else {
            exit('Data tidak ditemukan.');
        }

        return view('suppliers/edit');
    }

    public function addSupplier()
    {
        if ($this->request->isAJAX()) {
            $idSupplier = esc($this->request->getVar('idSupplier'));
            $nameSupplier = esc($this->request->getVar('nameSupplier'));
            $addressSupplier = esc($this->request->getVar('addressSupplier'));
            $telpSupplier = esc($this->request->getVar('telpSupplier'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                'idSupplier' => [
                    'label' => 'Id Penyuplai',
                    'rules' => 'required|is_unique[supplier.sup_kode]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ],
                'nameSupplier' => [
                    'label' => 'Nama Penyuplai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'addressSupplier' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'telpSupplier' => [
                    'label' => 'Telepon',
                    'rules' => 'required|regex_match[/^(?:\+62|0)[2-9]\d{7,11}$/]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'regex_match' => 'Format Nomor {field} tidak valid'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'errorIdSupplier' => $validation->getError('idSupplier'),
                        'errorNameSupplier' => $validation->getError('nameSupplier'),
                        'errorAddressSupplier' => $validation->getError('addressSupplier'),
                        'errorTelpSupplier' => $validation->getError('telpSupplier')
                    ]
                ];
            } else {
                $this->suppliers->insert([
                    'sup_kode' => $idSupplier,
                    'sup_nama' => $nameSupplier,
                    'sup_alamat' => $addressSupplier,
                    'sup_telp' => $telpSupplier
                ]);

                $msg = [
                    'success' => 'Penyuplai berhasil ditambahkan.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function editSupplier()
    {
        if ($this->request->isAJAX()) {
            $idSupplier = esc($this->request->getVar('idSupplier'));
            $nameSupplier = esc($this->request->getVar('nameSupplier'));
            $addressSupplier = esc($this->request->getVar('addressSupplier'));
            $telpSupplier = esc($this->request->getVar('telpSupplier'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                'nameSupplier' => [
                    'label' => 'Nama Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'addressSupplier' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'telpSupplier' => [
                    'label' => 'Telepon',
                    'rules' => 'required|regex_match[/^(?:\+62|0)[2-9]\d{7,11}$/]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'regex_match' => 'Format Nomor {field} tidak valid'
                    ]
                ]
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'errorNameSupplier' => $validation->getError('nameSupplier'),
                        'errorAddressSupplier' => $validation->getError('addressSupplier'),
                        'errorTelpSupplier' => $validation->getError('telpSupplier')
                    ]
                ];
            } else {
                $this->suppliers->update($idSupplier, [
                    'sup_nama' => $nameSupplier,
                    'sup_alamat' => $addressSupplier,
                    'sup_telp' => $telpSupplier
                ]);

                $msg = [
                    'success' => 'Penyuplai berhasil diperbarui.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function deleteSupplier()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idSupplier'));

            $this->suppliers->delete([
                'sup_kode' => $id
            ]);

            $msg = [
                'success' => 'Penyuplai berhasil dihapus.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus Penyuplai gagal.');
        }
    }
}
