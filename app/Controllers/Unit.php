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
            $id = $this->request->getVar('idUnit');
            $name = $this->request->getVar('namaUnit');

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
            $id = $this->request->getVar('idUnit');
            $name = $this->request->getVar('nameUnit');

            $data = [
                'satid' => $id,
                'satnama' => $name
            ];

            $this->units->insert($data);

            $msg = [
                'success' => 'Satuan ditambahkan.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, tambah satuan gagal.');
        }
    }

    public function editUnit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('idUnit');
            $name = $this->request->getVar('nameUnit');

            $data = [
                'satnama' => $name
            ];

            $this->units->update($id, $data);

            $msg = [
                'success' => 'Satuan diedit.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, edit satuan gagal.');
        }
    }

    public function deleteUnit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('idUnit');

            $data = [
                'satid' => $id
            ];

            $this->units->delete($data);

            $msg = [
                'success' => 'Satuan dihapus.'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus satuan gagal.');
        }
    }
}
