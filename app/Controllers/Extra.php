<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;


class Extra extends ResourceController
{
    public $upload_key;
    public $db;
    // public $upload_key;
    public function __construct()
    {
        $this->upload_key = $_ENV['UPLOAD_KEY'];
        $this->db = \Config\Database::connect();
    }

    public function uploaderext($id = 'files', $url = 'https://api.brnjuara.com/api/upload-files', $text = 'Jatuhkan file disini!')
    {
        // $db      = \Config\Database::connect();
        return view('App\Views\components\uploaderext', array(
            'id' => $id, $url => $url, $text => $text
        ));
    }

    public function regional($city = 0, $subdistrict = 0, $region_id = 'prov', $area_id = 'city', $subdistrict_id = 'subdistrict')
    {
        // $db      = \Config\Database::connect();
        return view('App\Views\components\region', array(
            'areas' => $city, 'subdistrict' => $subdistrict, 'region_id' => $region_id, 'area_id' => $area_id, 'subdistrict_id' => $subdistrict_id
        ));
    }
    public function regionaljs($city = 0, $subdistrict = 0, $region_id = 'prov', $area_id = 'city', $subdistrict_id = 'subdistrict')
    {
        // $db      = \Config\Database::connect();
        return view('App\Views\components\region', array(
            'areas' => $city, 'subdistrict' => $subdistrict, 'region_id' => $region_id, 'area_id' => $area_id, 'subdistrict_id' => $subdistrict_id
        ));
    }


    public function get_regions($is_registered = false)
    {
        
        // print_r($this->request->getVar());exit;
        
        $page = $this->request->getVar('page');
        $term = $this->request->getVar('term');
        // $page = $this->request->getVar('page');
        $q = $this->db->table('regions');
        $selected_id = $this->request->getVar('id');
        if($selected_id != null ){
            $q = $q->whereNotIn('id', [$selected_id]);
        }
        if($is_registered){
            $q = $q->where('is_registered', 1);
        }
        if($page && $page > 0){
            $q = $q->limit(20, $page-1);
        }
        if($term && $term != ''){
            $q = $q->like('region', $term, 'both');
        }


        $data = $q->get()->getResult();
        
        $selected = array();
        if($selected_id != null){
            $selected = $this->db->table('regions')->where('id', $selected_id)->get()->getRowArray();
        }
        if(isset($selected['id'])){
            $data = (array)$data;
            // print_r($data[0]);exit;
            $data[] = (array)$selected;
            // $data = array_unique($data);
            $data = (object)$data;
        }
        return $this->respond(array(
            'error' => 0,
            'message' => '',
            'data' => $data
        ),200);exit;
    }
    public function get_areas($region_id, $is_registered = false)
    {
        // print_r($this->request->getVar());exit;
        $page = $this->request->getVar('page');
        $term = $this->request->getVar('term');

        $q = $this->db->table('areas')->where('region_id', $region_id);
        $selected_id = $this->request->getVar('id');
        if($selected_id != null ){
            $q = $q->whereNotIn('id', [$selected_id]);
        }
        if($is_registered){
            $q = $q->where('is_registered', 1);
        }

        if($page && $page > 0){
            $q = $q->limit(20, $page-1);
        }
        if($term && $term != ''){
            $q = $q->like('area', $term, 'both');
        }


        $data = $q->get()->getResult();
        $selected = array();
        if($selected_id != null){
            $selected = $this->db->table('areas')->where('id', $selected_id)->get()->getRowArray();
        }
        if(isset($selected['id'])){
            $data = (array)$data;
            $data[] = $selected;
            $data = array_unique($data);
            $data = (object)$data;
        }
        return $this->respond(array(
            'error' => 0,
            'message' => '',
            'data' => $data
        ),200);exit;
    }
    public function get_subdistrict($area_id, $is_registered = false)
    {
        // print_r($this->request->getVar());exit;
        $page = $this->request->getVar('page');
        $term = $this->request->getVar('term');

        $q = $this->db->table('subdistrict')->where('area_id', $area_id);
        $selected_id = $this->request->getVar('id');
        if($selected_id != null ){
            $q = $q->whereNotIn('id', [$selected_id]);
        }
        if($is_registered){
            $q = $q->where('is_registered', 1);
        }

        if($page && $page > 0){
            $q = $q->limit(20, $page-1);
        }
        if($term && $term != ''){
            $q = $q->like('subdistrict_name', $term, 'both');
        }


        $data = $q->get()->getResult();
        $selected = array();
        if($selected_id != null){
            $selected = $this->db->table('subdistrict')->where('id', $selected_id)->get()->getRowArray();
        }
        if(isset($selected['id'])){
            $data = (array)$data;
            $data[] = $selected;
            $data = array_unique($data);
            $data = (object)$data;
        }
        return $this->respond(array(
            'error' => 0,
            'message' => '',
            'data' => $data
        ),200);exit;
    }

    public function valid_email($id = null)
    {
        if (!$this->validate([
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|is_unique[users.email, users.id, {id}]',
                'errors' => [
                    'required' => 'Email harus diisi!',
                    'is_unique' => 'Email sudah dipakai user lain!',
                    'valid_email' => 'Format email salah!'
                ],
            ]
        ])) {
            // echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()['email']]);
            return $this->respond(['error' => 1, 'message' => $this->validator->getErrors()['email']], 200, $this->validator->getErrors()['email']);
            exit;
        }

        return $this->respond(['error' => 0, 'message' => 'OK'], 200, 'OK');
    }

    public function valid_phone($id = null)
    {
        if (!$this->validate([
            'phone' => [
                'label'  => 'No HP',
                'rules'  => 'required|is_unique[user_personal_informations.phone_number, user_personal_informations.user_id, {id}]',
                'errors' => [
                    'required' => 'No HP harus diisi!',
                    'is_unique' => 'No HP sudah dipakai user lain!'
                ],
            ],
        ])) {
            // echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()['phone']]);
            return $this->respond(['error' => 1, 'message' => $this->validator->getErrors()['phone']], 200, $this->validator->getErrors()['phone']);
            exit;
        }

        return $this->respond(['error' => 0, 'message' => 'OK'], 200, 'OK');
    }

    public function valid_nik($id = null)
    {
        if (!$this->validate([
            'nik_ktp' => [
                'label'  => 'NIK KTP',
                'rules'  => 'required|is_unique[user_personal_informations.nik_ktp, user_personal_informations.user_id, {id}]',
                'errors' => [
                    'required' => 'NIK KTP harus diisi!',
                    'is_unique' => 'NIK KTP sudah dipakai user lain!'
                ],
            ],
        ])) {
            // echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()['phone']]);
            return $this->respond(['error' => 1, 'message' => $this->validator->getErrors()['nik_ktp']], 200, $this->validator->getErrors()['nik_ktp']);
            exit;
        }

        return $this->respond(['error' => 0, 'message' => "OK"], 200, 'OK');
    }
}
