<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;


class CarsController extends \App\Controllers\BaseAdmin
{

    // public function __construct()
    // {
    //     // $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/article/';
    //     // print_r(UPLOADS_PATH);exit;
    // }

    public function index()
    {
        echo view('Brn\Views\cars\list');
    }

    public function listajax()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('cars')->select('
        cars.stnk_image,
        cars.machine_number,
        cars.stnk_number,
        cars.police_number,
        cars.stnk_image,
        cars.is_approved,
        cars.chassis_number,
        cars.year,
        cars.stnk_image,
        cf.fuel,
        cm.make,
        cmd.model,
        ct.class,
        u.name,
        upi.id_card,
        ccl.color,
        korw.region,
        kord.area,
        crp.status, cars.status, crp.id')->join('users as u', 'cars.user_id = u.id', 'left')->join('car_fuels as cf', 'cars.car_fuel_id = cf.id', 'left')->join('car_makes as cm', 'cars.car_make_id = cm.id', 'left')->join('car_models as cmd', 'cars.car_model_id = cmd.id', 'left')->join('car_colors as ccl', 'cars.car_color_id = ccl.id', 'left')->join('car_types as ct', 'cars.car_type_id = ct.class', 'left')->join('user_personal_informations as upi', 'u.id = upi.user_id', 'left')->join('regions as korw', 'korw.id = upi.korwil_id', 'left')->join('areas as kord', 'kord.id = upi.korda_id', 'left')->join('case_reports as crp', 'cars.id = crp.car_id', 'left');
        return DataTable::of($builder)
            ->setSearchableColumns(['u.name', 'u.email', 'upi.phone_number', 'upi.id_card', 'upi.nik'])
            ->filter(function ($builder, $request) {
        
                if (property_exists($request, 'type') && $request->type != '' && $request->type != null){
                    $builder->where('ct.id', $request->type);
                }
                if (property_exists($request, 'model') && $request->model != '' && $request->model != null){
                    $builder->where('cmd.id', $request->model);
                }
                if (property_exists($request, 'make') && $request->make != '' && $request->make != null){
                    $builder->where('cm.id', $request->make);
                }
                if (property_exists($request, 'fuel') && $request->fuel != '' && $request->fuel != null){
                    $builder->where('cf.id', $request->fuel);
                }
                if (property_exists($request, 'korwil') && $request->korwil != '' && $request->korwil != null){
                    $builder->where('korw.id', $request->korwil);
                }
                if (property_exists($request, 'korda') && $request->korda != '' && $request->korda != null){
                    $builder->where('kord.id', $request->korda);
                }
                if (property_exists($request, 'status') && $request->status != '' && $request->status != null){
                    $builder->where('cars.status', $request->status);
                }
                if (property_exists($request, 'hascase') && $request->hascase != '' && $request->hascase != null){
                    $builder->where('crp.status != NULL', NULL, false);
                }
        
            })
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        try {
            $q = $db->table('perpetrators')->where('id', $id)->delete();

            if($q){
                echo json_encode(['error' => 0, 'message' => 'Berhasil menghapus data!']);exit;
            }

            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!']);exit;
        } catch (\Throwable $th) {
            echo json_encode(['error' => 0, 'message' => 'Terjadi kesalahan! ', 'error_detail' => $th]);exit;
        }
    }
    

    public function insertcars()
    {
        // goto model
        $db      = \Config\Database::connect();
        try {
            $db->transBegin();
            $builder = $db->table('perpetrators');
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
