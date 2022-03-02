<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;

class UsersController extends BaseAdmin
{
    protected $upload_path;
    public function __construct()
    {
        $this->upload_path = $_ENV['UPLOAD_RELATIVE_BASE_PATH'] . '/users/';
        // print_r(UPLOADS_PATH);exit;
    }

    public function index($role = null)
    {
        $title = "User";
        // print_r($role);exit;
        if ($role == 'new') {
            $title .= " Pendaftar Baru";
        } else if ($role == 'ext') {
            $title .= " Perpanjangan";
        }else{
            $config = Config('Brn');
            // print_r($config->settings['roles'][0]);exit;
            foreach($config->settings['roles'] as $r){
                if ($role == $r['name']) {
                    $title .= " " . ($r['display_name'] == null ? strtoupper($role) : $r['display_name']);
                    break;
                }
            }
        }
        $data['role'] = $role;
        $data['title'] = $title;
        echo view('users/list', $data);
    }

    public function confirmation($id, $force = 0)
    {
        $db      = \Config\Database::connect();
        $currentrole = $db->query('SELECT * FROM model_has_roles WHERE model_id = ' . $id)->getNumRows();
        $user = $db->table('users')->where('id', $id)->get()->getRowObject();
        // $db->resetQuery();
        // print_r($currentrole);exit;
        $res = 0;

        if ($force == 0) {
            if ($user->payment_status == 0) {
                echo json_encode(array('error' => 1, 'message' => 'User ini belum menyeleseikan pembayaran', 'force_url' => base_url('users/tool/confirmation/' . $id . '/1')));
                exit;
            }
            if ($user->check_korwil == 0) {
                echo json_encode(array('error' => 1, 'message' => 'Korwil belum memverifikasi user ini!', 'force_url' => base_url('users/tool/confirmation/' . $id . '/1')));
                exit;
            }
            if ($user->check_korda == 0) {
                echo json_encode(array('error' => 1, 'message' => 'Korda belum memverifikasi user ini!', 'force_url' => base_url('users/tool/confirmation/' . $id . '/1')));
                exit;
            }
        }



        if ($currentrole == 0) {
            $res += $db->table('model_has_roles')->set(array('model_type' => 'App\Models\User', 'model_id' => $id, 'role_id' => 2))->insert();
            // print_r($res);exit;
        }
        $upd = $db->table('users')->set('status', 'membership')->update();
        $this->generateid($id, 1);
        // print_r($res);exit;
        if ($res > 0) {
            echo json_encode(array('error' => 0, 'message' => 'berhasil!'));
            exit;
        } else {
            echo json_encode(array('error' => 1, 'message' => 'gagal!'));
            exit;
        }
        echo json_encode(array('error' => 1, 'message' => 'error!'));
        exit;
    }

    public function formtambah($role = null)
    {
        $db      = \Config\Database::connect();
        $data = [];
        $data['roles'] = $db->table('roles')->get()->getResultObject();
        $data['korda_list'] = $db->table('regions')->where('is_registered', 1)->get()->getResult();
        $data['role'] = $role;
        echo view('users/form', $data);
    }

    public function form($id = null)
    {
        $db      = \Config\Database::connect();
        $data = [];
        $data['roles'] = $db->table('roles')->get()->getResultObject();
        if ($id !== null) {

            $user = $db->table('users as u')->join('user_personal_informations as upi', 'u.id = upi.user_id', 'left')->join('model_has_roles as mhr', 'u.id = mhr.model_id', 'left')->join('addresses as adr', 'u.id = adr.user_id', 'left')->where('u.id', $id)->get()->getRowObject();

            $data['data_id'] = $id;
            $data['data'] = $user;

            echo view('users/form', ['data_id' => $id, 'data' => $data]);
        } else {

            echo view('users/form', $data);
        }
    }

    public function admins()
    {
        $data['title'] = 'Admin';
        echo view('admin/list', $data);
    }

    public function listadminajax()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('admins as adm')->select('name, username, group_code, id');

        return DataTable::of($builder)
            ->setSearchableColumns(['name', 'username'])
            ->filter(function ($q, $request) {

                if (property_exists($request, 'group') && $request->group)
                    $q->where('group_code', $request->group);
            })
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    public function removeadmin($id)
    {
        $db = \Config\Database::connect();
        try {
            if ($db->table('admins')->where('id', $id)->delete()) {
                echo json_encode(['error' => 0, 'message' => 'Berhasil menghapus data!']);
                exit;
            }

            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!']);
            exit;
        } catch (\Throwable $th) {
            echo json_encode(['error' => 1, 'message' => 'Gagal menghapus data!', 'error_detail' => $th]);
            exit;
        }

        echo json_encode(['error' => 1, 'message' => 'Unknown error! Gagal menghapus data!']);
        exit;
    }

    public function ajax_resetpassword_admin($id)
    {
        try {
            $db = \Config\Database::connect();
            $res = $db->table('admins')->where('id', $id)->update(array('password' => password_hash("1234567890", PASSWORD_BCRYPT)));

            if ($res) {
                echo json_encode(['error' => 0, 'message' => 'Berhasil mereset password!']);
                exit;
            }
        } catch (\Throwable $th) {

            echo json_encode(['error' => 1, 'message' => 'Gagal mereset password!', "error_detail" => $th]);
            exit;
        }

        echo json_encode(['error' => 1, 'message' => 'Gagal mereset password!']);
        exit;
    }

    public function addadmin($id = null)
    {
        $db = \Config\Database::connect();
        $config = Config('Brn');
        $data['roles'] = $config->admin_roles;
        if ($id == null) {
            echo view('admin/form', $data);
        } else {
            $data['data'] = $db->table('admins')->where('id', $id)->get()->getRow();
            $data['data_id'] = $id;
            echo view('admin/form', $data);
        }
    }

    public function insertadmin()
    {
        if (!$this->validate([
            'name' => "required",
            'username' => "required|valid_email",
            'password' => "string",
            'confirm_password' => "string|matches[password]"
        ])) {
            echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);
            exit;
        }
        $id = $this->request->getVar('data_id');
        try {
            $db      = \Config\Database::connect();
            $res = false;
            $msg = "menambahkan";
            if ($id == null) {
                $res = $db->table('admins')->insert(array(
                    'name' => $this->request->getVar('name'),
                    'username' => $this->request->getVar('username'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'group_code' => $this->request->getVar('role') != null ? $this->request->getVar('role') : 'super_admin'
                ));
            } else {
                if ($this->request->getVar('password') != "") {
                    $res = $db->table('admins')->where('id', $id)->update(array(
                        'name' => $this->request->getVar('name'),
                        'username' => $this->request->getVar('username'),
                        'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                        'group_code' => $this->request->getVar('role') != null ? $this->request->getVar('role') : 'super_admin'
                    ));
                } else {
                    $res = $db->table('admins')->where('id', $id)->update(array(
                        'name' => $this->request->getVar('name'),
                        'username' => $this->request->getVar('username'),
                        'group_code' => $this->request->getVar('role') != null ? $this->request->getVar('role') : 'super_admin'
                    ));
                }

                $msg = "mengupdate";
            }

            if ($res) {
                echo json_encode(['error' => 0, 'message' => "Berhasil $msg admin!"]);
                exit;
            }
            echo json_encode(['error' => 1, 'message' => "Gagal $msg admin!"]);
        } catch (\Throwable $th) {
            echo json_encode(['error' => 1, 'message' => "Terjadi kesalahan!", "detail_error" => $th]);
            exit;
        }

        echo json_encode(['error' => 1, 'message' => "Terjadi kesalahan!", "detail_error" => "Unknown error!, plese contact dev!"]);
        exit;
    }

    public function insertuser()
    {
        // print_r($_FILES);exit;
        if($this->request->getVar('id_card') != null){
            if(!$this->validate(['id_card' => "is_unique[user_personal_informations.id_card]"])){
                echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);
            exit;
            }
        }
        if (!$this->validate([
            'name' => "required",
            'email' => "required|valid_email|is_unique[users.email]",
            'phone' => "required|is_unique[user_personal_informations.phone_number]",
            'nik_ktp' => "is_unique[user_personal_informations.nik_ktp]",
            
            'gender' => "required",
            'role' => "required",
            'korda' => 'required|numeric',
            'korwil' => 'required|numeric'
        ])) {
            echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);
            exit;
        }

        // goto model
        $thmasuk = $this->request->getVar('tahunmasuk');
        $db      = \Config\Database::connect();

        try {
            $db->transBegin();
            $builder = $db->table('users');
            $builder->insert(array(
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'password' => $this->request->getVar('password') != null ? password_hash($this->request->getVar('password'), PASSWORD_BCRYPT) : password_hash('1234567890', PASSWORD_BCRYPT),
                'profile_photo_path' => $this->request->getVar('image')
            ));

            $userid = $db->insertID();
            $builder->resetQuery();
            $builder = $db->table('model_has_roles');
            $builder->insert(array(
                'model_id' => $userid,
                'model_type' => 'App\Models\User',
                'role_id' => $this->request->getVar('role')
            ));

            $builder->resetQuery();
            
            $builder = $db->table('user_personal_informations');
            $builder->insert(array(
                'nik_ktp' => $this->request->getVar('nik'),
                'user_id' => $userid,
                'id_card' => $this->request->getVar('id_card') != null ? $this->request->getVar('id_card') : "",
                'gender' => $this->request->getVar('gender'),
                'place_of_birth' => $this->request->getVar('place_of_birth'),
                'date_of_birth' => $this->request->getVar('date_of_birth'),
                'korda_id' => $this->request->getVar('korda'),
                'korwil_id' => $this->request->getVar('korwil'),
                'profile_image' => $this->request->getVar('image')                
            ));

            // TODO, INSERT ALAMAT

            if ($db->transStatus() === false) {
                $db->transRollback();
                
            } else {
                $db->transCommit();
                echo json_encode(['error' => 0, 'message' => 'Berhasil menambahkan user!']);exit;
            }
            echo json_encode(['error' => 1, 'message' => 'Gagal menambahkan user!', 'detail_error' => $db->error()]);
        } catch (\Exception $e) {
            echo json_encode(['error' => 1, 'message' => $e->getMessage()]);
        }

        // echo json_encode($res);
        // exit;
    }

    public function generateid($iduser)
    {
        $idmember = [];
        $separator = ".";
        if ($iduser !== null) {
            $db      = \Config\Database::connect();
            $pinfo = $db->query('SELECT id from user_personal_informations WHERE user_id = ' . $iduser)->getNumRows();
            $data = $db->table('users as u')->select('upi.*, addr.*, reg.*, ars.*, u.id as uid')->join('user_personal_informations as upi', 'u.id = upi.user_id', 'left')->join('addresses as addr', 'u.id = addr.addressable_id', 'left')->join('regions as reg', 'addr.state = reg.id', 'left')->join('areas as ars', 'addr.city = ars.id', 'left')->where('u.id', $iduser)->get()->getRowObject();
            // print_R($data);exit;
            if ($data == null) {
                echo json_encode(array('error' => 1, 'message' => 'User tidak ditemukan!'));
                exit;
            }
            if ($data->id_card != null) {
                echo json_encode(['error' => 1, 'message' => 'ID member sudah terisi!']);
                exit;
            }
            if ($data->area_code == '' || $data->area_code == null) {
                $idmember[] = str_pad($data->area_code, 3, '0', STR_PAD_LEFT);
            }
            $idmember[] = date('Y');
            if ($data->gender == '' || $data->gender == null) {
                $idmember[] = str_pad("0", 2, '0', STR_PAD_LEFT);
            } else {
                $idmember[] = str_pad(($data->gender == 'male' ? 1 : 2), 2, '0', STR_PAD_LEFT);
            }


            $idmember[] = str_pad($data->uid, 4, '0', STR_PAD_LEFT);
            $res = implode($separator, $idmember);
            $x = 0;
            if ($pinfo == 0) {
                $x = $db->table('user_personal_informations')->insert(array('user_id' => $iduser, 'id_card' => $res));
            } else {
                $x = $db->table('user_personal_informations')->where('user_id', $iduser)->set(array('id_card' => $res))->update();
            }


            if ($x > 0) {
                echo json_encode(array('error' => 0, 'message' => 'Berhasil membuat no id member!'));
                exit;
            }
            echo json_encode(array('error' => 1, 'message' => 'Gagal membuat no id member!'));
            exit;
            // print_r($res);exit;
        }
        echo json_encode(array('error' => 1, 'message' => 'Terjadi kesalahan!'));
        exit;
    }

    public function listajax($role = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('users as u')->select('u.name, u.email, p.id_card, u.id, u.payment_status as payment, u.check_korda as vkorda, u.check_korwil as vkorwil, count(mr.model_id), u.points, u.status')->join('user_personal_informations as p', 'u.id = p.user_id', 'left')->join('point_user pu', 'u.id = pu.user_id', 'left')->groupBy('pu.user_id');
        if ($role != null) {
            $builder->join('model_has_roles as mr', 'u.id = mr.model_id', 'left')->join('roles as r', 'mr.role_id = r.id', 'left');
            if ($role == 'new') {
                $builder = $builder->where('mr.model_id is NULL', null, false)->where('u.status', 'registration');
            } else if ($role == 'ext') {
                $builder = $builder->where('p.id_card is NOT NULL', NULL, false)->where('u.status', 'extension');
            } else {
                $builder = $builder->where('mr.model_id is NOT NULL', null, false)->where('r.name', $role);
            }
            $builder->groupBy('mr.model_id, u.name, u.email, p.id_card, u.id, payment, vkorda, vkorwil');
        } else {
            $builder->join('model_has_roles as mr', 'u.id = mr.model_id', 'right')->join('roles as r', 'mr.role_id = r.id', 'left');
        }

        return DataTable::of($builder)
            ->setSearchableColumns(['u.name', 'u.email', 'p.id_card'])
            ->filter(function ($q, $request) {

                if (property_exists($request, 'korda') && $request->korda)
                    $q->where('p.korda_id', $request->korda);

                if (property_exists($request, 'korwil') && $request->korwil)
                    $q->where('p.korwil_id', $request->korwil);
            })
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }

    // public function addarticle()
    // {
    //     $img = [];
    //     if (!$this->validate([
    //         'title' => "required",
    //         'content' => "required",
    //         'status' => "required",
    //     ])) {
    //         echo json_encode(['error' => 1, 'message' => $this->validator->getErrors()]);
    //         exit;
    //     }
    //     if (!isset($_FILES) || count($_FILES) == 0) {
    //         echo json_encode(['error' => 1, 'message' => 'Gambar harus diisi!']);
    //         exit;
    //     } else {
    //         $img = $this->uploadimg();
    //     }


    //     $res = $this->insertarticle($img);

    //     echo json_encode($res);
    //     exit;
    // }

    public function sluggable($text)
    {
        $slug = preg_replace("/-$/", "", preg_replace('/[^a-z0-9]+/i', "-", strtolower($text)));
        return $slug . time();
    }

    // private function insertarticle($img)
    // {
    //     // goto model
    //     $db      = \Config\Database::connect();

    //     try {
    //         $db->transBegin();
    //         $builder = $db->table('articles');
    //         $builder->insert(array(
    //             'title' => $this->request->getPost('title'),
    //             'content' => $this->request->getPost('content'),
    //             'image' => (count($img) == 0) ? '' : $img[0],
    //             'status' => $this->request->getPost('status'),
    //             'slug' => $this->sluggable($this->request->getPost('title'))
    //         ));

    //         if ($db->transStatus() === false) {
    //             $db->transRollback();
    //         } else {
    //             $db->transCommit();
    //             return ['error' => 0, 'message' => 'Berhasil menambahkan user!'];
    //         }
    //         return ['error' => 1, 'message' => 'Gagal menambahkan user!'];
    //     } catch (\Exception $e) {
    //         return ['error' => 1, 'message' => $e->getMessage()];
    //     }

    //     return ['error' => 1, 'message' => 'Gagal menambahkan data user!'];
    // }

    public function uploadimg()
    {
        $files = $this->request->getFiles();
        $res = [];
        foreach ($files as $file) {
            if (!$file->isValid()) {
                throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
            }
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
}
