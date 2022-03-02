<?php

namespace Olshop\Controllers;


use \Hermawan\DataTables\DataTable;


class Product extends \App\Controllers\BaseAdmin
{
    protected $upload_path;

    public function __construct()
    {
        $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/product/';
        // print_r(UPLOADS_PATH);exit;
    }

    public function index()
    {
        echo view('Olshop\Views\product\index');
    }

    public function deleteimage($pd_id = null, $return = false)
    {
        $name = $this->request->getVar('name');
        // print_r($name);exit;
        $db      = \Config\Database::connect();
        $res = [];
        if ($pd_id !== null) {

            $images = $db->table('olshop_pd_image')->where('id', $pd_id)->get()->getResult();
            $res = [];
            foreach ($images as $image) {
                $filepath = ROOTPATH . 'public' . $image->image_path;
                try {
                    $file = new \CodeIgniter\Files\File($filepath, true);
                    if (unlink($filepath)) {
                        $db->table('olshop_pd_image')->where('image_path', $image->image_path)->delete();
                        $res[] = ['error' => 0, 'message' => 'Berhasil menghapus file!', 'file' =>  $image->image_path];
                    }
                    unset($file);
                } catch (\Throwable $th) {
                    //throw $th;
                    if(gettype($th) == 'object' && get_class($th) === "CodeIgniter\Files\Exceptions\FileNotFoundException"){
                        // print_r($pd_id);exit;
                        $db->table('olshop_pd_image')->where('image_path', $image)->delete();
    
                        $res[] = ['error' => 1, 'message' => 'File tidak ditemukan!', 'file' =>  $image];
                        // exit;                    
                    }
                    $res[] = ['error' => 1, 'message' => 'Error! hubungi developer', 'file' =>  $image];
                    unset($file);
                }
               
            }
        } else if ($pd_id == null && $name != "") {
            $filepath = ROOTPATH . 'public' . $name;
            try {
                $file = new \CodeIgniter\Files\File($filepath, true);
                $res = [];
                if (unlink($filepath)) {
                    $db->table('olshop_pd_image')->where('image_path', $name)->delete();
                    $res = ['error' => 0, 'message' => 'Berhasil menghapus!', 'file' =>  $name];
                }
                unset($file);
                
            } catch (\Throwable $th) {
                //throw $th;
                if(gettype($th) == 'object' && get_class($th) === "CodeIgniter\Files\Exceptions\FileNotFoundException"){
                    // print_r($pd_id);exit;
                    $db->table('olshop_pd_image')->where('image_path', $name)->delete();

                    $res = ['error' => 1, 'message' => 'File tidak ditemukan!', 'file' =>  $name];;                   
                }
                $res = ['error' => 1, 'message' => 'Error! hubungi developer', 'file' =>  $name];
                unset($file);
            }
           
        }
        if($return == true){
            return $res;
        }
        echo json_encode($res);
        exit;
    }

    public function form($id = null)
    {
        if ($id !== null) {
            $db      = \Config\Database::connect();
            $data = $db->table('olshop_product')->where('id', $id)->get()->getRowObject();
            // print_r($data->is_published == 1);exit;
            echo view('Olshop\Views\product\form', ['data_id' => $id, 'data' => $data]);
        } else {
            echo view('Olshop\Views\product\form');
        }
    }

    public function selectcategories($id = "pd_cat_id", $classes = "form-control form-control-user", $tabindex = 0, $data_id = null)
    {
        $db      = \Config\Database::connect();
        $data = $db->table('olshop_pd_category')->get();
        return view('Olshop\Views\product\select_categories', array(
            'id' => $id, 'classes' => $classes, 'tabindex' => $tabindex, 'data' => $data->getResult(), 'data_id' => $data_id
        ));
    }

    public function listimage($data_id)
    {
        $db      = \Config\Database::connect();
        $data = $db->table('olshop_pd_image')->where('pd_id', $data_id)->get();
        return view('Olshop\Views\product\listimage', array(
            'data' => $data->getResult()
        ));
    }

    public function addproduct()
    {
        $img = [];
        if (!$this->validate([
            'pd_name' => "required",
            'pd_price'  => 'required|numeric',
            'pd_desc' => 'required',
            'pd_weight' => 'required|numeric',
            'pd_cat_id' => 'required',
            'is_published' => 'required|numeric'
        ])) {
            echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);
            exit;
        }
        if (!isset($_FILES) || count($_FILES) == 0) {
            echo json_encode(['error' => 1, 'message' => 'Gambar harus diisi!']);
            exit;
        } else {
            $img = $this->uploadimg();
        }


        $res = $this->insertproduct($img);

        echo json_encode($res);
        exit;
    }

    public function publish($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('olshop_product')->where('id', $id);
        $data = $builder->select('is_published')->get()->getRow();
        $msg = "Publish";
        if ($data->is_published == 0) {
            $builder->set('is_published', 1)->where('id', $id);
        } else {
            $builder->set('is_published', 0)->where('id', $id);
            $msg = "Unpublish";
        }
        if (!$builder->update()) {
            echo json_encode(array(
                'error' => 1,
                'message' => "Gagal $msg produk ini!"
            ));
            exit;
        }

        echo json_encode(array(
            'error' => 0,
            'message' => "Berhasil $msg produk ini!"
        ));
        exit;
    }

    public function delete($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('olshop_product')->where('id', $id);

        if (!$builder->delete()) {
            echo json_encode(array(
                'error' => 1,
                'message' => "Gagal menghapus produk ini!"
            ));
            exit;
        }

        echo json_encode(array(
            'error' => 0,
            'message' => "Berhasil menghapus produk ini!"
        ));
        exit;
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
                'pd_weight' => $this->request->getPost('pd_weight'),
                'pd_image_path' => (count($img) == 0) ? '' : $img[0]
            ));
            $id = $db->insertID();
            $builder = $db->table('olshop_pd_image');
            $dtimg = [];
            foreach ($img as $im) {
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
        foreach ($files as $file) {
            if (!$file->isValid()) {
                throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
                // echo json_encode(['error' => $file->getErrorString().'('.$file->getError().')']);exit;
                // $res[] = $file->getErrorString().'('.$file->getError().')';
            }
            // $type = $file->getMimeType();
            // print_r($this->upload_path);exit;
            $name = $file->getRandomName();
            $file->move(PUBLICPATH . $this->upload_path, $name);
            if ($file->hasMoved()) {
                $res[] = $this->upload_path . $name;
            } else {
                echo json_encode(['error' => 1, 'message' => 'Tidak dapat mengupload gambar!']);
                exit;
            }
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
