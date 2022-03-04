<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="flex items-center space-x-4">
            <a href="<?= base_url('sponsors') ?>" class="flex items-center mr-md-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>&nbspKembali
            </a>
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Sponsor</h6>
        </div>
    </div>
    <div class="card-body">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Nama Perusahaan/Sponsor</label>
                        <input type="title" class="form-control form-control-user" id="title" tabindex="0" placeholder="Contoh : PT. Sphonsor Ship..." name="title" value="<?php echo isset($data) && isset($data->title) ? $data->title : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Tentang Sponsor</label>
                        <textarea name="description" id="description" class="form-control form-control-user" cols="30" rows="10" tabindex="1"><?php echo isset($data) && isset($data->description) ? $data->description : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Kontak Sponsor</label>
                        <input type="email" class="form-control form-control-user" id="email" tabindex="0" placeholder="Contoh : user@sponsor.com" name="email" value="<?php echo isset($data) && isset($data->email) ? $data->email : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">No HP Kontak Sponsor</label>
                        <input type="text" class="form-control form-control-user" id="phone_number" tabindex="0" placeholder="Contoh : 08xxxxxx" name="phone_number" value="<?php echo isset($data) && isset($data->phone_number) ? $data->phone_number : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="website">Website Sponsor</label>
                        <input type="text" class="form-control form-control-user" id="website" tabindex="0" placeholder="Contoh : sponsorwebsite.com" name="website" value="<?php echo isset($data) && isset($data->website) ? $data->website : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <?= view_cell("\App\Controllers\Extra::uploaderext", ['id' => 'logo', 'text' => 'Klik atau jatuhkan file Logo Sponsor disini!']) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="active" <?php echo isset($data) && (int)$data->active == 1 ? "checked" : '' ?>>
                            <label class="custom-control-label" for="active">Sponsor aktif? (jika iya, maka Sponsor akan terlihat di aplikasi)</label>
                        </div>
                    </div>
                </div>
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
    // var tgllahir = $('.tgllahir').datepicker({
    //     startView: 2,
    //     title: "Tanggal Lahir",
    //     language: 'id',
    //     format: {
    //         /*
    //          * Say our UI should display a week ahead,
    //          * but textbox should store the actual date.
    //          * This is useful if we need UI to select local dates,
    //          * but store in UTC
    //          */
    //         toDisplay: function(date, format, language) {
    //             var d = new Date(date);

    //             // d.setDate(d.getDate() - 7);
    //             return d.toLocaleDateString('ID');
    //         },
    //         toValue: function(date, format, language) {
    //             var d = new Date(date);
    //             d.setDate(d.getDate() + 7);
    //             return new Date(d);
    //         }
    //     }
    // });
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
    var ds = $("#logo").dropzone({
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
            image = response.data.file_paths[0];
            sendapi(response.data.file_paths[0]);
            // console.log(response);
        },
        sending: function(file, xhr, formData) {
            formData.append('key', 'freekeetiiw');
            // console.log(formData);
        }
    });

    function sendapi(images = "") {
        Toast.fire({
            icon: 'info',
            title: "menyimpan ke database!"
        });
        var params = {
            title: $('#title').val(),
            website: $('#website').val(),
            email: $('#email').val(),
            phone_number: phone.getRawValue(),
            image: images,
            description: $('#description').val(),
            active: $('#active').val() == 'on' ? 1 : 0,
            data_id: null
        };
        <?php if(isset($data_id) && $data_id != null){ ?>
            params['data_id'] = <?= $data_id ?>;
            <?php } ?>
        // console.log(params);return;
        var urls = "<?= base_url('sponsors/insert') ?>";
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
                confirmButtonText: 'Kembali ke halaman Sponsor',
                cancelButtonText: "Tambah sponsor lainnya"
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

    

    function cekdata() {
        if ($('#title').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Nama Sponsor/Perusahaan Tidak boleh kosong!',
                'error'
            );
            return false;
        }
        if ($('#description').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Deskripsi Perusahaan Tidak boleh kosong!',
                'error'
            );
            return false;
        }
        if ($('#email').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Email Perusahaan Tidak boleh kosong!',
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

        let form = $('#logo');
        var dzone = document.querySelector("#logo").dropzone;
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