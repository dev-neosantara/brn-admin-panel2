<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Pelaku(Blacklist)</h6>
    </div>
    <div class="card-body">

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-user" id="name" tabindex="0" placeholder="Jhon Dorry" name="name" value="<?php echo isset($data) && isset($data->name) ? $data->name : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" class="form-control form-control-user" cols="30" rows="10" tabindex="1"><?php echo isset($data) && isset($data->address) ? $data->address : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK KTP Pelaku</label>
                        <input data-validationurl="<?= base_url('extra/valid_bl_nik') ?>" type="text" class="form-control form-control-user" id="nik" tabindex="2" placeholder="32700xxx" minlength="16" maxlength="17" name="nik" value="<?php echo isset($data) && isset($data->nik) ? $data->nik : '' ?>">
                        <span id="nik_errors" class="text-red-400"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4 pr-2">
                        <?php if (isset($data_id) && $data->profile_photo_path != "") { ?>
                            <div class="col-md-12">
                                <label for="">Foto KTP Sebelumnya</label>
                                <img class="h-32" src="https://api.brnjuara.com/storage/<?= $data->profile_photo_path ?>" alt="foto ktp">
                            </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <label for="">Foto KTP</label>
                            <form action="<?= 'https://api.brnjuara.com/api/upload-files' ?>" method="post" class="dropzone" id="pdimg">
                                <!-- <div id="pdimg"></div> -->
                                <div class="dz-message" data-dz-message><span>Klik atau jatuhkan file foto KTP disini!</span></div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="case_report_id">Kasus Terkait</label>
                                <select name="case_report_id" id="case_report_id" class="form-control form-control-user" tabindex="3">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phone_number">No HP</label>
                                <input data-validationurl="<?= base_url('extra/valid_bl_phone') ?>" type="text" class="form-control form-control-user" id="phone_number" tabindex="4" placeholder="08xxxx" name="phone_number" value="<?php echo isset($data) && property_exists($data, 'phone_number') ? $data->phone_number : '' ?>">
                                <span id="phone_number_errors" class="text-red-400"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="birth_date">Tgl Lahir</label>
                                <div class="input-group date tgllahir" data-provide="datepicker" tabindex="5">
                                    <input type="text" class="form-control" id="birth_date" placeholder="01/01/2001">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="chronology">Kronologi/Informasi Tambahan</label>
                        <textarea name="chronology" id="chronology" class="form-control form-control-user" cols="30" rows="10" tabindex="1"><?php echo isset($data) && isset($data->chronology) ? $data->chronology : '' ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="is_published" <?php //echo isset($data) && (int)$data->is_published == 1 ? "checked" : '' 
                                                                                                    ?>>
                            <label class="custom-control-label" for="is_published">Publish Artikel ini? (jika iya, maka Artikel akan langsung terlihat)</label>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-12">
                    <button onclick="send()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('foot') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/addons/cleave-phone.id.js" integrity="sha512-U479UBH9kysrsCeM3Jz6aTMcWIPVpmIuyqbd+KmDGn6UJziQQ+PB684TjyFxaXiOLRKFO9HPVYYeEmtVi/UJIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- <script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script> -->
<!-- <script src="<?= base_url() ?>/lib/ckeditor/ckeditor.js"></script> -->
<script>
    var image = "";
    var tgllahir = $('.tgllahir').datepicker({
        startView: 2,
        title: "Tanggal Lahir",
        language: 'id',
        format: {
            /*
             * Say our UI should display a week ahead,
             * but textbox should store the actual date.
             * This is useful if we need UI to select local dates,
             * but store in UTC
             */
            toDisplay: function(date, format, language) {
                var d = new Date(date);

                // d.setDate(d.getDate() - 7);
                return d.toLocaleDateString('ID');
            },
            toValue: function(date, format, language) {
                var d = new Date(date);
                d.setDate(d.getDate() + 7);
                return new Date(d);
            }
        }
    });
    var phone = new Cleave('#phone_number', {
        phone: true,
        phoneRegionCode: 'ID',
        onValueChanged: function(e) {
            let target = document.querySelector('#phone_number');
            let val = e.target.rawValue.replace("+62", "0");
            validation(target, val);
        }
    });

    // var contentdata = "";
    Dropzone.autoDiscover = false;
    var ds = $("#pdimg").dropzone({
        paramName: "files[]", // The name that will be used to transfer the file
        maxFilesize: 10, // MB
        autoProcessQueue: false,
        multiple: false,
        accept: function(file, done) {
            if (done) {
                done();
            }
        },
        success: function(file, response) {
            sendapi(response.data.file_paths[0]);
            // console.log(response);
        },
        sending: function(file, xhr, formData) {
            formData.append('key', 'freekeetiiw');
            console.log(formData);
        }
    });

    function sendapi(images = "") {
        Toast.fire({
            icon: 'info',
            title: "menyimpan ke database!"
        });
        var params = {
            name: $('#name').val(),
            nik: $('#nik').val(),
            phone_number: phone.getRawValue,
            profile_photo_path: images,
            case_report_id: $('#case_report_id').val(),
            address: $('#address').val(),
            birth_date: $('#birth_date').val(),
            chronology: $('#chronology').val(),
            data_id: null
        };
        <?php if(isset($data_id) && $data_id != null){ ?>
            params['data_id'] = <?= $data_id ?>;
            <?php } ?>
        // console.log(params);return;
        var urls = "<?= base_url('blacklist/insert') ?>";
        axios.post(urls, params)
            .then(function(response) {
                // console.log(response.data);
                // var data = JSON.parse(response);
                // console.log(data);
                image = images;
                if (response.data.error == 0) {
                    successins(true, response.data.message);
                } else {

                    successins(false, response.data.message);
                }

            })
            .catch(function(error) {
                image = images;
                console.log(error);
                successins(false, error);
            });
    }

    function successins(success = true, message) {
        if (success) {
            Swal.fire({
                title: message,
                text: "Tekan ok untuk kembali",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Kembali ke halaman list Pelaku',
                cancelButtonText: "Tambah pelaku lainnya"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                } else {
                    window.location.reload();
                }
            });
        } else {
            Swal.fire(
                message,
                message,
                'error'
            )
        }

    }

    function validation(target, val = false) {
        let url = target.dataset.validationurl;
        let key = target.name;
        let value = val ? val : target.value;
        if (value == "" || key == "" || url == "") {
            return;
        }
        let params = {};
        params[key] = value;

        axios.post(url, params)
            .then(function(response) {
                // console.log(response.data);
                if (parseInt(response.data.error) == 1 && document.querySelector('#' + key + "_errors").innerText == "") {

                    Toast.fire({
                        icon: 'error',
                        title: response.data.message
                    })
                    document.querySelector('#' + key + "_errors").innerText = response.data.message;
                    target.classList.add('border-red-400');
                } else if (parseInt(response.data.error) == 0) {
                    document.querySelector('#' + key + "_errors").innerText = "";
                    target.classList.remove('border-red-400');
                }

            })
            .catch(function(error) {
                console.log(error);
                Toast.fire({
                    icon: 'error',
                    title: 'Tidak dapat memvalidasi data ' + key
                })
            });
    }

    function cekdata() {
        if ($('#nik').val() == '') {
            Swal.fire(
                'Perhatian!',
                'NIK KTP Tidak boleh kosong!',
                'error'
            );
            return false;
        }
        if ($('#name').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Nama Tidak boleh kosong!',
                'error'
            );
            return false;
        }
        return true;
    }

    function send() {
        let data = cekdata();
        if (!data) {
            return;
        }

        let form = $('#pdimg');
        var dzone = document.querySelector("#pdimg").dropzone;
        if (dzone.getQueuedFiles().length > 0) {
            Toast.fire({
                icon: 'info',
                title: "sedang upload gambar! mohon tunggu"
            });
            dzone.processQueue();
        } else {
            dzone.uploadFiles([]); //send empty 
        }
    }
</script>

<?= $this->endSection() ?>