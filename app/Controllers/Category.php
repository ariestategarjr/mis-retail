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
        $data = [
            'categories' => $this->categories->findAll()
        ];

        return view('categories/data', $data);
    }

    public function addFormModal()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('categories/addFormModal')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf, halaman tidak bisa ditampilkan.');
        }
    }

    public function editFormModal()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id-category');
            $name = $this->request->getVar('name-category');

            $data = array(
                'id_category' => $id,
                'name_category' => $name
            );

            $msg = [
                'data' => view('categories/editFormModal', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function addCategory()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id-category');
            $name = $this->request->getVar('name-category');

            $data = array(
                'katid' => $id,
                'katnama' => $name
            );

            $this->categories->insert($data);

            $msg = [
                'success' => 'category success add'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, tambah kategori gagal.');
        }
    }

    public function editCategory()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id-category');
            $name = $this->request->getVar('name-category');

            $data = array(
                'katnama' => $name
            );

            $this->categories->update($id, $data);

            $msg = [
                'success' => 'category success edit'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, edit kategori gagal.');
        }
    }

    public function deleteCategory()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id-category');

            $this->categories->delete([
                'katid' => $id
            ]);

            $msg = [
                'success' => 'category success delete'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf, hapus kategori gagal.');
        }
    }
}
