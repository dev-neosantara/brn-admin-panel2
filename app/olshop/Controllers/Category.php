<?php

namespace Olshop\Controllers;


use \Hermawan\DataTables\DataTable;


class Category extends \App\Controllers\BaseAdmin
{
    protected $upload_path;

    public function __construct()
    {
        $this->upload_path = ROOTPATH.'public/category';
        // print_r(UPLOADS_PATH);exit;
    }

    public function index()
    {
        echo view('Olshop\Views\category\index');
    }

    public function form($id = null)
    {
        if($id !== null){
            $db      = \Config\Database::connect();
            $data = $db->table('olshop_pd_category')->where('id', $id)->get()->getRowObject();
            // print_r($data->is_published == 1);exit;

            echo view('Olshop\Views\category\form', ['data_id' => $id, 'data' => $data]);
        }else{
            echo view('Olshop\Views\category\form');
        }
    }

    public function addcategory()
    {
        $img = [];
        if (! $this->validate([
            'cat_name' => "required",
            'cat_code' => "required"
        ])) {
            echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);exit;
        }
        if(!isset($_FILES) || count($_FILES) == 0){
            echo json_encode(['error' => 1, 'message' => 'Gambar harus diisi!']);exit;
        }else{
            $img = $this->uploadimg();
        }   

        $res = $this->insertproduct($img);

        echo json_encode($res);exit;
        
    }



    public function delete($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('olshop_product')->where('id', $id);
        
        if(!$builder->delete()){
            echo json_encode(array(
                'error' => 1,
                'message' => "Gagal menghapus produk ini!"
            ));exit;
        }

        echo json_encode(array(
            'error' => 0,
            'message' => "Berhasil menghapus produk ini!"
        ));exit;
    }

    private function insertproduct($img)
    {
        // goto model
        $db      = \Config\Database::connect();
        
        try {
            $db->transBegin();
            $builder = $db->table('olshop_product');
            $builder->insert(array(
                'pd_name' => $this->request->getPost('pd_name'),
                'pd_price' => $this->request->getPost('pd_price'),
                'pd_cat_id' => $this->request->getPost('pd_cat_id'),
                'onboarding' => $this->request->getPost('onboarding'),
                'is_published' => $this->request->getPost('is_published'),
                'pd_image_path' => (count($img) == 0) ? '' : $img[0]
            ));
            $id = $db->insertID();
            $builder = $db->table('olshop_pd_image');
            $dtimg = [];
            foreach($img as $im){
                $dtimg[] = array('image_path' => $im, 'pd_id' => $id);
            }
            $builder->insertBatch($dtimg);
            if ($db->transStatus() === false) {
                $db->transRollback();
                
            } else {
                $db->transCommit();
                return ['error' => 0, 'message' => 'Berhasil menambahkan produk!'];
            }
            return ['error' => 1, 'message' => 'Gagal menambahkan produk!'];
        } catch (\Exception $e) {
            return ['error' => 1, 'message' => $e->getMessage()];
        }

        return ['error' => 1, 'message' => 'Gagal menambahkan data produk!'];
    }

    public function uploadimg()
    {
        $files = $this->request->getFiles();
        $res = [];
        foreach($files as $file){
            if (! $file->isValid()) {
                throw new \RuntimeException($file->getErrorString().'('.$file->getError().')');
                // echo json_encode(['error' => $file->getErrorString().'('.$file->getError().')']);exit;
                // $res[] = $file->getErrorString().'('.$file->getError().')';
            }
            $type = $file->getMimeType();
            $res[] = $file->store(PUBLIC_PATH.'/');
            
        }
        return $res;
    }

    public function listajax()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('olshop_product')->select('pd_name, pd_price, onboarding, is_published,id');
        return DataTable::of($builder)
                ->setSearchableColumns(['pd_name'])
               ->addNumbering() //it will return data output with numbering on first column
               ->toJson();
    }
}
