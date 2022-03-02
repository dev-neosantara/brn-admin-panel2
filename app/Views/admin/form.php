    <?= $this->extend('App\Views\template') ?>
    <?= $this->section('head') ?>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?= $this->endSection() ?>
    <?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah User</h6>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row border-b mb-4 pb-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-user" id="name" tabindex="0" placeholder="Nama Lengkap" name="name" value="<?php echo isset($data) && property_exists($data, 'name') ? $data->name : '' ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-user" id="email" tabindex="1" placeholder="Email" name="email" value="<?php echo isset($data) && property_exists($data, 'username') ? $data->username : '' ?>">
                                </div>
                            </div>
                            <?php if(isset($data_id)){ ?>
                            <div class="col-md-12 border-t pt-4">
                                <p>Kosongkan input password di bawah jika tidak ingin mengubah password!</p>
                            </div>
                            <?php } ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label for="password">
                                    <?php if(isset($data_id)){ ?>
                                        Password
                                    <?php }else{ ?>
                                        Password(Jika kosong, default ke 12345678)    
                                        <?php } ?>
                                    </label>
                                    <input type="password" class="form-control form-control-user" id="password" tabindex="2" name="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label for="password_confirm">
                                        Ulangi Password (harus sama persis dengan password)
                                    </label>
                                    <input type="password" class="form-control form-control-user" id="password_confirm" tabindex="3" name="password_confirm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="role">Jabatan/Role</label>
                            <select name="role" id="role" class="form-control form-control-user">
                                <option value="">Pilih Role !</option>
                                <?php if (isset($roles)) {
                                    foreach ($roles as $role) :
                                ?>
                                        <option value="<?= $role['id']; ?>" <?= isset($data) && property_exists($data, 'group_code') && $data->group_code == $role['id'] ? 'selected' : '' ?>><?= $role['name']; ?></option>
                                <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="retalinfo">

                </div>
                <div class="row">
                    <!-- <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="is_published" <?php //echo isset($data) && (int)$data->is_published == 1 ? "checked" : '' ?>>
                            <label class="custom-control-label" for="is_published">Publish Admin ini? (jika iya, maka Admin akan langsung terlihat)</label>
                        </div>
                    </div>
                </div> -->
                    <div class="col-md-12">
                        <button onclick="send()" class="btn btn-primary">
                        Tambah Admin
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>
    <?= $this->section('foot') ?>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        const baseUrl = "<?= base_url('users') ?>";
        const dataid = `<?= isset($data_id) ? $data_id : "" ?>`;

        function sendapi(name, username, pass, confirm, role) {
            var urls = "<?= base_url('/admins/insert') ?>";
            axios.post(urls, {
                    name: name,
                    username: username,
                    password: pass,
                    confirm_password: confirm,
                    role: role,
                    data_id: dataid == "" ? null : parseInt(dataid)
                })
                .then(function(response) {
                    console.log(response.data);
                    // var data = JSON.parse(response);
                    // console.log(data);
                    
                    if(response.data.error == 0){
                        successins(true, response.data.message);
                    }else{
                        successins(false, response.data.message);
                    }
                    
                })
                .catch(function(error) {
                    console.log(error);
                    successins(false, error.message);
                });
        }
        // Dropzone.autoDiscover = false;

        // var ds = $("#pdimg").dropzone({
        //     paramName: "pd_img", // The name that will be used to transfer the file
        //     maxFilesize: 10, // MB
        //     autoProcessQueue: false,
        //     multiple: true,
        //     accept: function(file, done) {
        //         if (done) {
        //             done();
        //         }
        //     },
        //     successmultiple: function() {
        //         successins(true)
        //     },
        //     errormultiple: function() {
        //         successins(false)
        //     },
        //     sending: function(file, xhr, formData) {
        //         formData.append('title', $('#title').val());
        //         formData.append('content', $('#content').val());

        //         formData.append('status', $('#is_published').val() == 'on' ? "PUBLISHED" : "DRAFT");
        //         <?php if (isset($data_id)) { ?>
        //             formData.append('data_id', <?= $data_id ?>)
        //         <?php } ?>
        //     }
        // });

        function successins(success = true, message = "Mohon periksa kembali data yang anda input!") {
            if (success) {
                Swal.fire({
                    title: 'Berhasil menambah data Admin!',
                    text: "Tekan ok untuk kembali",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Kembali ke halaman list Admin',
                    cancelButtonText: "Upload Admin lainnya"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();
                    } else {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire(
                    'Gagal menambah data Admin!',
                    message,
                    'error'
                )
            }

        }

        function cekdata() {
            if ($('#name').val() == '') {
                Swal.fire(
                    'Error validasi!',
                    "Nama tidak boleh kosong!",
                    'error'
                );
                return false;
            }
            if ($('#email').val() == '') {
                Swal.fire(
                    'Error validasi!',
                    "Email tidak boleh kosong!",
                    'error'
                );
                return false;
            }
            if ($('#password').val() !== "" && ($('#password').val() !== $('#password_confirm').val())) {
                Swal.fire(
                    'Error validasi!',
                    "Password harus sama persis!",
                    'error'
                );
                return false;
            }
            if ($('#password').val() == '') {
                Swal.fire(
                    'Password dikosongkan?',
                    "Jika password kosong, maka untuk user ini akan diberi password default 12345678, lanjutkan?",
                    'warning'
                );
            }

            return true;
        }

        function send() {
            let data = cekdata();
            if (data) {
                sendapi(
                    $('#name').val(), $('#email').val(), $('#password').val(), $('#password_confirm').val(), $('#role').val()
                );
            }
        }
    </script>
    <?= $this->endSection() ?>