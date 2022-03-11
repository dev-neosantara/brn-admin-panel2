<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;


class EventController extends \App\Controllers\BaseAdmin
{
    protected $upload_path;
    public function __construct()
    {
        $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/agenda/';
        // print_r(UPLOADS_PATH);exit;
    }

    public function index($id)
    {
        $data['agenda_id'] = $id;
        $db = \Config\Database::connect();
        $data['data'] = $db->table('agendas')->where('id', $id)->get()->getRow();
        echo view('Brn\Views\events\detail', $data);
    }

    public function listajax($agenda_id = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('agenda_user as au')->select('u.name, upi.phone_number, upi.id_card, au.created_at as tanggal, au.user_id, ag.title, au.agenda_id')->join('users as u', 'au.user_id = u.id', 'left')->join('agendas as ag', 'au.agenda_id = ag.id', 'left')->join('user_personal_informations as upi', 'au.user_id = upi.user_id', 'left')->where('au.agenda_id', $agenda_id)->orderBy('au.created_at', 'desc');
        return DataTable::of($builder)
            ->setSearchableColumns(['upi.nik_ktp', 'upi.id_card', 'upi.phone_number', 'u.name', 'u.email', 'ag.title'])
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    public function uploadimg()
    {
        $files = $this->request->getFiles();
        $res = [];
        foreach ($files as $file) {
            if (!$file->isValid()) {
                throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
            }
            $name = $file->getRandomName();
            $file->move(PUBLIC_PATH . $this->upload_path, $name);
            if ($file->hasMoved()) {
                $res[] = $this->upload_path . $name;
            } else {
                echo json_encode(['error' => 1, 'message' => 'Tidak dapat mengupload gambar!']);
                exit;
            }
        }
        return $res;
    }

    public function insert()
    {
        // print_r($this->request->getVar('data_id') == null);exit;
    //     [title] => asdasd
    // [latitude] => -7.371596217768559
    // [longitude] => 109.67206791043283
    // [description] => asdasda
    // [start_date] => 2022-03-10
    // [end_date] => 2022-03-19
    // [start_time] => 05:30
    // [type] => hut
    // [address] => asdasd
    // [area_id] => 28
    // [data_id] => null
        $db      = \Config\Database::connect();
        $image = "";
        if(isset($_FILES)){
            $image = $this->uploadimg();
        }
        try {
            $db->transBegin();
            $builder = $db->table('agendas');
            if($this->request->getVar('data_id') != null && $this->request->getVar('data_id') != 'null'){
                $builder->set(array(
                    'title' => $this->request->getVar('title'),
                    'description' => $this->request->getVar('description'),
                    'image' => count($image) > 0 ? $image[0] : "",
                    'longitude' => $this->request->getVar('longitude'),
                    'latitude' => $this->request->getVar('latitude'),
                    'start_date' => $this->request->getVar('start_date'),
                    'end_date' => $this->request->getVar('end_date'),
                    'start_time' => $this->request->getVar('start_time'),
                    'end_time' => "00:00",
                    'address' => $this->request->getVar('address'),
                    'type' => $this->request->getVar('type'),
                    'area_id' => $this->request->getVar('area_id')
                ))->where('id', $this->request->getVar('data_id'))->update();
            }else{
                $builder->insert(array(
                    'title' => $this->request->getVar('title'),
                    'description' => $this->request->getVar('description'),
                    'image' => count($image) > 0 ? $image[0] : "",
                    'longitude' => $this->request->getVar('longitude'),
                    'latitude' => $this->request->getVar('latitude'),
                    'start_date' => $this->request->getVar('start_date'),
                    'end_date' => $this->request->getVar('end_date'),
                    'start_time' => $this->request->getVar('start_time'),
                    'end_time' => "00:00",
                    'address' => $this->request->getVar('address'),
                    'type' => $this->request->getVar('type'),
                    'area_id' => $this->request->getVar('area_id')
                ));
            }
           
        
            if ($db->transStatus() === false) {
                $db->transRollback();
            } else {
                $db->transCommit();
                echo json_encode(['error' => 0, 'message' => 'Berhasil menambahkan data agenda!']);exit;
            }
            echo json_encode(['error' => 1, 'message' => 'Gagal menambahkan data agenda!', 'details' => $this->db->error()]);exit;
        } catch (\Exception $e) {
            echo json_encode(['error' => 1, 'message' => $e->getMessage()]);exit;
        }

        echo json_encode(['error' => 1, 'message' => 'Gagal menambahkan data agenda!']);exit;
    }
}