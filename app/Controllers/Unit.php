<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUnits;
use \Hermawan\DataTables\DataTable;

class Unit extends BaseController
{
    public function __construct()
    {
        // parent::__construct();
        $this->ModelUnits = new ModelUnits();
    }

    public function index()
    {
        $data_table = DataTable::of($this->ModelUnits->getAll())->toJson();
        $data = [
            'page' => 'view_units',
            'title' => 'Master',
            'subtitle' => 'Units',
            'menu' => 'master',
            'submenu' => 'units',
            'satuan' => $data_table
        ];
        return view('view_template', $data);
    }

    public function validation() {
        $rules = [
            [
                'field' => 'id_satuan',
                'label' => 'id satuan',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'nama_satuan',
                'label' => 'nama satuan',
                'rules' => 'trim|required'
            ]
        ];
        
        $this->form_validation->set_rules($rules); //menerapkan rules validasi pada mahasiswa_model
        
        return $validation->run();
    }

    public function add() {
        $data = [
            'id_satuan' => $this->request->getPost('id_satuan'),
            'nama_satuan' => $this->request->getPost('nama_satuan')
        ];

        $this->ModelUnits->insertData($data);
        return redirect()->to(base_url('unit')); 
    }
}
