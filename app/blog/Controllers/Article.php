<?php

namespace Blog\Controllers;


use \Hermawan\DataTables\DataTable;


class Article extends \App\Controllers\BaseAdmin
{
    protected $upload_path;

    public function __construct()
    {
        $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/article/';
        // print_r(UPLOADS_PATH);exit;
    }

    public function index()
    {
        echo view('Blog\Views\list');
    }

    public function publish($id)
    {
        $db = \Config\Database::connect();
        $cat = $db->table('articles')->select('articles.*')->where('id', $id)->get()->getRowArray();
        $msg = 'Publish';
        if (count($cat) > 0) {

            $set = array(
                'status' => 'published'
            );
            if ($cat['status'] == 'published') {
                $set['status'] = 'draft';
                $msg = 'Unpublish';
            }

            $db->table('articles')->set($set)->where('id', $id)->update();
            echo json_encode(['error' => 0, 'message' => 'Berhasil ' . $msg . ' artikel']);
            exit;
        }

        echo json_encode(['error' => 1, 'message' => 'Gagal ' . $msg . ' artikel']);
        exit;
    }

    public function form($id = null)
    {
        $db      = \Config\Database::connect();
        $cat = $db->table('categories')->select('categories.*')->get()->getResultObject();
        if ($id !== null) {
            $data = $db->table('articles')->where('id', $id)->get()->getRowObject();
            echo view('Blog\Views\form', ['data_id' => $id, 'data' => $data, 'categories' => $cat]);
        } else {
            echo view('Blog\Views\form', ['categories' => $cat]);
        }
    }

    public function listajax()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('articles')->select('articles.title, users.email, articles.status, articles.id')->join('users', 'articles.user_id = users.id');
        return DataTable::of($builder)
            ->setSearchableColumns(['title', 'email'])
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    public function deletearticle($id)
    {
        $db = \Config\Database::connect();
        try {
            $q = $db->table('articles')->where('id', $id)->delete();
            if ($q) {
                $q = $db->table('articles')->where('id', $id)->delete();
            }

            if ($q) {
                echo json_encode(['error' => 0, 'message' => 'Berhasil menghapus data!']);
                exit;
            }

            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!']);
            exit;
        } catch (\Throwable $th) {
            echo json_encode(['error' => 0, 'message' => 'Terjadi kesalahan! ', 'error_detail' => $th]);
            exit;
        }
    }

    public function deletecat($id)
    {
        $db = \Config\Database::connect();
        try {
            $q = $db->table('categories')->where('id', $id)->delete();
            if ($q) {
                $q = $db->table('categorizables as cat')->where('cat.categorizable_type', 'App\Models\Article')->where('cat.categorizable_id', $id)->delete();
            }

            if ($q) {
                echo json_encode(['error' => 0, 'message' => 'Berhasil menghapus data!']);
                exit;
            }

            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!']);
            exit;
        } catch (\Throwable $th) {
            echo json_encode(['error' => 0, 'message' => 'Terjadi kesalahan! ', 'error_detail' => $th]);
            exit;
        }
    }

    public function addarticle()
    {
        $img = [];
        if (!$this->validate([
            'title' => "required",
            'content' => "required",
            'status' => "required",
        ])) {
            echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);
            exit;
        }


        $res = $this->insertarticle();

        echo json_encode($res);
        exit;
    }

    public function categoriesajax($type = null)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('categories')->select('name, slug, id');

        return DataTable::of($builder)
            ->setSearchableColumns(['slug', 'name', 'description'])
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    public function categories()
    {
        echo view('Blog\Views\categories');
    }

    public function categoryadd($id = null)
    {
        $db      = \Config\Database::connect();
        $cat = $db->table('categories')->select('categories.*')->get()->getResultObject();

        if ($id != null) {
            $data = $db->table('categories')->where('id', $id)->get()->getRowObject();
            return view('Blog\Views\categoryadd', ['categories' => $cat, 'data_id' => $id, 'data' => $data]);
        }

        echo view('Blog\Views\categoryadd', ['categories' => $cat]);
    }

    public function categoryinsert()
    {
        // print_r($this->request->getVar('name'));exit;
        if (!$this->validate([
            'name' => "required"
        ])) {
            echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);
            exit;
        }
        $db      = \Config\Database::connect();

        $id = $this->request->getVar('data_id');
        $builder = $db->table('categories');
        $msg = "menambahkan";
        if ($id == null) {
            $x = $builder->insert(array(
                'name' => $this->request->getVar('name'),
                'description' => $this->request->getVar('description'),
                'parent_id' => $this->request->getVar('parent'),
                'slug' => $this->sluggable($this->request->getVar('name'), 'categories', 'slug', 'category'),
            ));
        } else if ($id != null && ((int)$id) > 0) {
            $x = $builder->update(array(
                'name' => $this->request->getVar('name'),
                'description' => $this->request->getVar('description'),
                'parent_id' => $this->request->getVar('parent'),
                'slug' => $this->sluggable($this->request->getVar('name'), 'categories', 'slug', 'category'),
            ));
            $msg = 'mengubah';
        }
        $res = ['error' => 1, 'message' => "Tidak dapat $msg data kategori!"];
        if ($x) {
            $res['error'] = 0;
            $res['message'] = "Berhasil $msg data kategori!";
        }


        echo json_encode($res);
        exit;
    }


    public function sluggable($text, $table = 'articles', $slug_field = 'slug', $slug_category = 'article')
    {
        $slug = preg_replace("/-$/", "", preg_replace('/[^a-z0-9]+/i', "-", strtolower($text)));
        $db      = \Config\Database::connect();
        $res = "";
        $res = $slug_category . "-" . $slug;
        $exist = $db->table($table)->where($slug_field, $res)->countAll();
        if ($exist > 0) {
            $res = $slug_category . "-" . $slug . '-' . ($exist + 1);
        }
        return $res;
    }

    private function insertarticle()
    {
        // goto model
        $img = $this->request->getVar('image');
        $db      = \Config\Database::connect();

        try {
            $db->transBegin();
            $builder = $db->table('articles');
            $msg = 'menambahkan';
            if ($this->request->getVar('data_id') != null) {
                $builder->update(array(
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'image' => (count($img) == 0) ? '' : $img[0],
                    'status' => $this->request->getPost('status'),
                    'slug' => $this->sluggable($this->request->getPost('title'))
                ), array('id' => $this->request->getVar('data_id')));
                $builder = $db->table('categorizables');
                $builder->update(array(
                    'category_id' => $this->request->getPost('category')
                ), array('categorizable_id' => $this->request->getVar('data_id'), 'categorizable_type' => 'App\Models\Article'));
            }else{
                $builder->insert(array(
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'image' => (count($img) == 0) ? '' : $img[0],
                    'status' => $this->request->getPost('status'),
                    'slug' => $this->sluggable($this->request->getPost('title'))
                ));
                $idcat = $db->insertID();
                $builder = $db->table('categorizables');
                $builder->insert(array(
                    'category_id' => $this->request->getPost('category'),
                    'categorizable_id' => $idcat,
                    'categorizable_type' => 'App\Models\Article'
                ));
            }
           

            if ($db->transStatus() === false) {
                $db->transRollback();
            } else {
                $db->transCommit();
                return ['error' => 0, 'message' => 'Berhasil '.$msg.' artikel!'];
            }
            return ['error' => 1, 'message' => 'Gagal '.$msg.' artikel!'];
        } catch (\Exception $e) {
            return ['error' => 1, 'message' => $e->getMessage()];
        }

        return ['error' => 1, 'message' => 'Gagal '.$msg.' data artikel!'];
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
}
