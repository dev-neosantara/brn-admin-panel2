<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;
// use Endroid\QrCode\QrCode;
// use Endroid\QrCode\Writer\PngWriter;
use \chillerlan\QRCode\QRCode;
use \chillerlan\QRCode\QROptions;


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
            $data['data'] = $db->table('agendas')->where('id', $id)->get()->getRow();
        }
        // print_r($data);exit;
        echo view('Brn\Views\events\form', $data);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        try {
            

            if ($db->table('agendas')->where('id', $id)->delete()) {
                echo json_encode(['error' => 0, 'message' => 'Berhasil menghapus data!']);
                exit;
            }

            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!']);
            exit;
        } catch (\Throwable $th) {
            echo json_encode(['error' => 0, 'message' => 'Terjadi kesalahan! ', 'error_detail' => $db->error()]);
            exit;
        }
    }

    public function listajax($cat_id = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('agendas as ag')->select('ag.title, ag.description, ag.start_date, ag.end_date, ag.address, ag.type, ag.id, areas.area, ag.qr_path')->join('areas', 'ag.area_id = areas.id', 'left')->orderBy('ag.start_date', 'desc');
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

                $ids = $db->insertID();
                $this->generateqr($ids, true);
                
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

    private function generateqr($id, $update = true)
    {
        // $id = $this->request->getVar('id');
        try {
            $db      = \Config\Database::connect();
            $current = $db->table('agendas')->where('id', $id)->get()->getResult();
            
            // $options = new QROptions([
            //     'version'    => 5,
            //     'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            //     'eccLevel'   => QRCode::ECC_L,
            // ]);

            $filename = "/uploads/agenda/agendaQr_".time()."_".$id.".png";
            
            if((new QRCode)->render("https://api.brnjuara.com/api/agendas/".$id."/qr-scan", ROOTPATH . "public" . $filename)){
                $db->table('agendas')->where('id', $id)->set('qr_path', base_url($filename))->update();
                if(count($current) > 0){
                    if($current[0]->qr_path != ""){
                        $url = parse_url($current[0]->qr_path);
                        // print_r($url);exit;
                        if (file_exists(ROOTPATH . "public" . $url['path'])) {
                            unlink(ROOTPATH . "public" . $url['path']);
                         }
                    }
                   
                }
                return $filename;
            }
            return "";
        } catch (\Throwable $th) {
            print_r($th);exit;
        }
       
    }

    public function get_generateqr()
    {
        $id = $this->request->getVar('id');
        $qrpath = $this->generateqr($id);
        if($qrpath == ""){
            echo json_encode(['error' => 1, 'message' => 'Gagal mendapatkan qr!']);exit;
        }
        echo json_encode(['error' => 0, 'message' => 'OK!', 'data' => base_url($qrpath)]);exit;
    }

    public function invitation()
    {
        $id = $this->request->getVar('id');
        $db      = \Config\Database::connect();
        $data['data'] = $db->table('agendas')->where('id', $id)->get()->getRow();

        echo view('Brn\Views\events\invitation', $data);
    }
}