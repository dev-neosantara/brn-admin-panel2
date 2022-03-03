<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;


class SponsorsController extends \App\Controllers\BaseAdmin
{

    // public function __construct()
    // {
    //     // $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/article/';
    //     // print_r(UPLOADS_PATH);exit;
    // }

    public function index()
    {
        echo view('Brn\Views\sponsors\list');
    }

    public function form($id = null)
    {
        $db      = \Config\Database::connect();
        if ($id !== null) {
            $data = $db->table('sponsors')->where('id', $id)->get()->getRowObject();
            echo view('Brn\Views\sponsors\form', ['data_id' => $id, 'data' => $data]);
        } else {
            echo view('Brn\Views\sponsors\form');
        }
    }

    public function listajax()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('sponsors as sp')->select('sp.title, sp.image as logo, sp.website, sp.poin, sp.id');
        return DataTable::of($builder)
            ->setSearchableColumns(['sp.title', 'sp.website', 'sp.phone_number', 'sp.description'])
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        try {
            $q = $db->table('sponsors')->where('id', $id)->delete();

            if($q){
                echo json_encode(['error' => 0, 'message' => 'Berhasil menghapus data!']);exit;
            }

            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!']);exit;
        } catch (\Throwable $th) {
            echo json_encode(['error' => 0, 'message' => 'Terjadi kesalahan! ', 'error_detail' => $th]);exit;
        }
    }
    

    public function insert()
    {
        // goto model
        $db      = \Config\Database::connect();
        try {
            $db->transBegin();
            $builder = $db->table('sponsors');
            if($this->request->getVar('data_id') != null){
                $builder->set(array(
                    'title' => $this->request->getVar('title'),
                    'description' => $this->request->getVar('description'),
                    'phone_number' => $this->request->getVar('phone_number'),
                    'website' => $this->request->getVar('website'),
                    'email' => $this->request->getVar('email'),
                    'image' => $this->request->getVar('image'),
                ))->where('id', $this->request->getVar('data_id'))->update();
            }else{
                $builder->insert(array(
                    'title' => $this->request->getVar('title'),
                    'description' => $this->request->getVar('description'),
                    'phone_number' => $this->request->getVar('phone_number'),
                    'website' => $this->request->getVar('website'),
                    'email' => $this->request->getVar('email'),
                    'image' => $this->request->getVar('image'),
                ));
            }
           
        
            if ($db->transStatus() === false) {
                $db->transRollback();
            } else {
                $db->transCommit();
                echo json_encode(['error' => 0, 'message' => 'Berhasil menambahkan data sponsor!']);exit;
            }
            echo json_encode(['error' => 1, 'message' => 'Gagal menambahkan data sponsor!', 'details' => $this->db->error()]);exit;
        } catch (\Exception $e) {
            echo json_encode(['error' => 1, 'message' => $e->getMessage()]);exit;
        }

        echo json_encode(['error' => 1, 'message' => 'Gagal menambahkan data sponsor!']);exit;
    }
}
