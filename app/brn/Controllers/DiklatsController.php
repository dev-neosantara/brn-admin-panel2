<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;


class DiklatsController extends \App\Controllers\BaseAdmin
{

    // public function __construct()
    // {
    //     // $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/article/';
    //     // print_r(UPLOADS_PATH);exit;
    // }

    public function index()
    {
        echo view('Brn\Views\diklat\list');
    }

    public function form($id = null)
    {
        $db      = \Config\Database::connect();
        // $cat = $db->table('cases')->select('categories.*')->get()->getResultObject();
        $data['data'] = $db->table('courses')->where('id', $id)->get()->getRow();
        if ($id !== null) {
            echo view('Brn\Views\diklat\form', ['data_id' => $id, 'data' => $data]);
        } else {
            echo view('Brn\Views\blacklist\form');
        }
    }

    public function listajax()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('courses as c')->select('c.name as title, c.description, c.status, c.created_at, c.id, (SELECT count(cu.id) from course_user as cu WHERE cu.course_id = c.id) as user_count, (SELECT count(cl.id) from course_lessons as cl WHERE cl.course_id = c.id) as lesson_count');
        return DataTable::of($builder)
            ->setSearchableColumns(['title', 'c.description'])
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        try {
            $q = $db->table('courses')->where('id', $id)->delete();

            if($q){
                echo json_encode(['error' => 0, 'message' => 'Berhasil menghapus data!']);exit;
            }

            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!']);exit;
        } catch (\Throwable $th) {
            echo json_encode(['error' => 0, 'message' => 'Terjadi kesalahan! ', 'error_detail' => $th]);exit;
        }
    }
    

    public function insertcourse()
    {
        // goto model
        $db      = \Config\Database::connect();
        try {
            $db->transBegin();
            $builder = $db->table('courses');
            if($this->request->getVar('data_id') != null){
                $builder->set(array(
                    'name' => $this->request->getVar('name'),
                    'address' => $this->request->getVar('address'),
                    'nik' => $this->request->getVar('nik'),
                    'case_report_id' => $this->request->getVar('case_report_id'),
                    'phone_number' => $this->request->getVar('phone_number'),
                    'profile_photo_path' => $this->request->getVar('profil_photo_path'),
                    'chronology' => $this->request->getVar('chronology'),
                    'birth_date' => $this->request->getVar('birth_date'),
                ))->where('id', $this->request->getVar('data_id'))->update();
            }else{
                $builder->insert(array(
                    'name' => $this->request->getVar('name'),
                    'address' => $this->request->getVar('address'),
                    'nik' => $this->request->getVar('nik'),
                    'case_report_id' => $this->request->getVar('case_report_id'),
                    'phone_number' => $this->request->getVar('phone_number'),
                    'profile_photo_path' => $this->request->getVar('profil_photo_path'),
                    'chronology' => $this->request->getVar('chronology'),
                    'birth_date' => $this->request->getVar('birth_date'),
                ));
            }
           
        
            if ($db->transStatus() === false) {
                $db->transRollback();
            } else {
                $db->transCommit();
                echo json_encode(['error' => 0, 'message' => 'Berhasil menambahkan data pelaku!']);exit;
            }
            echo json_encode(['error' => 1, 'message' => 'Gagal menambahkan data pelaku!', 'details' => $this->db->error()]);exit;
        } catch (\Exception $e) {
            echo json_encode(['error' => 1, 'message' => $e->getMessage()]);exit;
        }

        echo json_encode(['error' => 1, 'message' => 'Gagal menambahkan data pelaku!']);exit;
    }
}
