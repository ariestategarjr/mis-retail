<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomersModel;

class Customer extends BaseController
{
    public function __construct()
    {
        $this->customers = new CustomersModel();
    }

    public function index()
    {
        if (session()->get('username') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('login'));
        }

        $data = [
            'customers' => $this->customers->orderby('pel_nama', 'asc')->findAll()
        ];

        return view('customers/data', $data);
    }

    public function add()
    {
        return view('customers/add');
    }

    public function edit($id)
    {
        $row = $this->customers->find($id);

        if ($row) {
            $data = [
                'idCustomer' => $row['pel_kode'],
                'nameCustomer' => $row['pel_nama'],
                'addressCustomer' => $row['pel_alamat'],
                'telpCustomer' => $row['pel_telp']
            ];
            return view('customers/edit', $data);
        } else {
            exit('Data tidak ditemukan.');
        }

        return view('customers/edit');
    }

    public function addCustomer()
    {
        if ($this->request->isAJAX()) {
            $idCustomer = esc($this->request->getVar('idCustomer'));
            $nameCustomer = esc($this->request->getVar('nameCustomer'));
            $addressCustomer = esc($this->request->getVar('addressCustomer'));
            $telpCustomer = esc($this->request->getVar('telpCustomer'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                'idCustomer' => [
                    'label' => 'Id Pelanggan',
                    'rules' => 'required|is_unique[pelanggan.pel_kode]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba yang lain'
                    ]
                ],
                'nameCustomer' => [
                    'label' => 'Nama Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'addressCustomer' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'telpCustomer' => [
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
                        'errorIdCustomer' => $validation->getError('idCustomer'),
                        'errorNameCustomer' => $validation->getError('nameCustomer'),
                        'errorAddressCustomer' => $validation->getError('addressCustomer'),
                        'errorTelpCustomer' => $validation->getError('telpCustomer')
                    ]
                ];
            } else {
                $this->customers->insert([
                    'pel_kode' => $idCustomer,
                    'pel_nama' => $nameCustomer,
                    'pel_alamat' => $addressCustomer,
                    'pel_telp' => $telpCustomer
                ]);

                $msg = [
                    'success' => 'Pelanggan berhasil ditambahkan.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function editCustomer()
    {
        if ($this->request->isAJAX()) {
            $idCustomer = esc($this->request->getVar('idCustomer'));
            $nameCustomer = esc($this->request->getVar('nameCustomer'));
            $addressCustomer = esc($this->request->getVar('addressCustomer'));
            $telpCustomer = esc($this->request->getVar('telpCustomer'));

            $validation = \Config\Services::validation();

            $validate = $this->validate([
                'nameCustomer' => [
                    'label' => 'Nama Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'addressCustomer' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'telpCustomer' => [
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
                        'errorNameCustomer' => $validation->getError('nameCustomer'),
                        'errorAddressCustomer' => $validation->getError('addressCustomer'),
                        'errorTelpCustomer' => $validation->getError('telpCustomer')
                    ]
                ];
            } else {
                $this->customers->update($idCustomer, [
                    'pel_nama' => $nameCustomer,
                    'pel_alamat' => $addressCustomer,
                    'pel_telp' => $telpCustomer
                ]);

                $msg = [
                    'success' => 'Pelanggan berhasil diperbarui.'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function deleteCustomer()
    {
        if ($this->request->isAJAX()) {
            $id = esc($this->request->getVar('idCustomer'));

            $this->customers->delete([
                'pel_kode' => $id
            ]);

            $msg = [
                'success' => 'Pelanggan berhasil dihapus.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus pelanggan gagal.');
        }
    }
}
