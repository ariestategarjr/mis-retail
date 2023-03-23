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
            $msg = [
                'data' => view('units/add')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, halaman tidak bisa ditampilkan.');
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
                'success' => 'satuan berhasil ditambahkan'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, tambah unit gagal.');
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
                'success' => 'satuan berhasil dihapus'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus unit gagal.');
        }
    }
}
