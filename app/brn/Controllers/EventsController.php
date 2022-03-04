<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;


class EventsController extends \App\Controllers\BaseAdmin
{
    protected $upload_path;
    public function __construct()
    {
        $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/agenda/';
        // print_r(UPLOADS_PATH);exit;
    }

    public function index()
    {
        echo view('Brn\Views\events\list');
    }

    public function form($id = null)
    {
        $data = [];
        $db      = \Config\Database::connect();
        $data['categories'] = [
            'hut' => 'HUT',
            'tour' => 'TOUR',
            'kopdar' => 'KOPDAR',
            'uncategorized' => 'Tanpa Kategori'
        ];
        if($id != null){
            $data['data_id'] = $id;
        }
        echo view('Brn\Views\events\form', $data);
    }

    public function listajax($cat_id = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('agendas as ag')->select('ag.title, ag.description, ag.start_date, ag.end_date, ag.address, ag.type, ag.id, areas.area')->join('areas', 'ag.area_id = areas.id', 'left')->orderBy('ag.start_date', 'desc');
        return DataTable::of($builder)
            ->setSearchableColumns(['ag.title', 'ag.description', 'ag.address'])
            ->filter(function ($builder, $request) {
        
                if (property_exists($request, 'type') && $request->type != '' && $request->type != null){
                    $builder->where('ag.type', $request->type);
                }
                    
                if (property_exists($request, 'filters')){
                    switch ($request->filters) {
                        case 'thismonth':
                            $builder->where('MONTH(ag.start_date)', date('m'));
                            $builder->where('YEAR(ag.start_date)', date('Y'));
                            break;
                        case 'today':
                            $builder->where('MONTH(ag.start_date)', date('m'));
                            $builder->where('YEAR(ag.start_date)', date('Y'));
                            $builder->where('DAY(ag.start_date)', date('d'));
                            break;
                        case 'upcoming':
                            $builder->where('ag.start_date > ', date('Y-m-d'));
                            break;
                        default:
                            # code...
                            break;
                    }
                }
        
            })
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