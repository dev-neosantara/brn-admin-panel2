<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;


class EventsController extends \App\Controllers\BaseAdmin
{
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

    public function insert()
    {
        print_r($this->request->getVar());exit;
        $db      = \Config\Database::connect();
        try {
            $db->transBegin();
            $builder = $db->table('events');
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