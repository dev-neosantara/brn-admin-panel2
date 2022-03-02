<?= $this->extend('App\Views\templateiframe') ?>
<?= $this->section('head') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Produk</h6>

    </div>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pd_name">Nama Produk</label>
                        <input type="text" class="form-control form-control-user" id="pd_name" tabindex="0" placeholder="Masukan Nama Produk" name="pd_name" value="<?php echo isset($data) && isset($data->pd_name) ? $data->pd_name : '' ?>">

                    </div>
                    <div class="form-group">
                        <label for="pd_desc">Deskripsi Produk Produk</label>
                        <textarea name="pd_desc" id="pd_desc" class="form-control" cols="30" rows="10" tabindex="1"><?php echo isset($data) && isset($data->pd_desc) ? $data->pd_desc : '' ?></textarea>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pd_weight">Berat Produk</label>
                        <div class="d-flex justify-content-between align-items-center">
                            <input type="text" class="form-control form-control-user pdweight" id="pd_weight" tabindex="3" name="pd_weight" value="<?php echo isset($data) && isset($data->pd_weight) ? $data->pd_weight : '' ?>">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="pd_cat">Kategori Produk</label>

                        <?= view_cell("\Olshop\Controllers\Product::selectcategories") ?>

                    </div>
                    <div class="form-group">
                        <label for="pd_price">Harga Produk</label>
                        <div class="d-flex justify-content-between align-items-center">
                            <input type="text" class="form-control form-control-user pdprice" id="pd_price" tabindex="2" placeholder="Masukan Harga Produk" name="pd_price" value="<?php echo isset($data) && isset($data->pd_price) ? $data->pd_price : '' ?>">
                        </div>

                    </div>
                </div>

            </div>
            <div class="row mb-4 pr-2">
                <?php if(isset($data_id)){ ?>
                <div class="col-md-12">
                    <?= view_cell("\Olshop\Controllers\Product::listimage", ['data_id' => $data_id]) ?>
                </div>
                <?php } ?>
                <div class="col-md-12">
                    <form action="<?php echo (isset($data_id)) ? base_url('/olshop/product/update') : base_url('/olshop/product/add') ?>" method="post" class="dropzone" id="pdimg">
                        <!-- <div id="pdimg"></div> -->
                        <div class="dz-message" data-dz-message><span>Klik atau jatuhkan file foto produk disini!</span></div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="is_published" <?php echo isset($data) && (int)$data->is_published == 1 ? "checked" : '' ?>>
                            <label class="custom-control-label" for="is_published">Publish Produk ini? (jika iya, maka produk akan langsung terlihat)</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="onboarding" <?php echo isset($data->onboarding) && $data->onboarding == 1 ? "checked" : '' ?>>
                            <label class="custom-control-label" for="onboarding">Tampilkan di Onboarding untuk Produk ini? (jika iya, maka produk akan terlihat di onboarding)</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button onclick="send()">Tambah Produk</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('foot') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
    if (typeof Cleave !== 'undefined') {
        var pd_price = new Cleave('.pdprice', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: 'Rp',
            numeralDecimalMark: ',',
            delimiter: '.'
        });
        <?php if (isset($pd_price)) { ?>
            pd_price.setRawValue("<?= $pd_price ?>");
        <?php } ?>
        var pd_weight = new Cleave('.pdweight', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalMark: ',',
            delimiter: '.'
        });
        <?php if (isset($pd_weight)) { ?>
            pd_weight.setRawValue("<?= $pd_weight ?>");
        <?php } ?>

    }

    $('.pdcat').select2();
    Dropzone.autoDiscover = false;
    var ds = $("#pdimg").dropzone({
        paramName: "pd_img", // The name that will be used to transfer the file
        maxFilesize: 10, // MB
        autoProcessQueue: false,
        multiple: true,
        accept: function(file, done) {
            if (done) {
                console.log('selesai');
                done();
            }
        },
        successmultiple: function(){
            successins(true)
        },
        errormultiple: function(){
            successins(false)
        },
        sending: function(file, xhr, formData) {
            formData.append('pd_name', $('#pd_name').val());
            formData.append('pd_price', document.querySelector("#pd_price").value.substr(2).split(".").join(""));
            formData.append('pd_weight', document.querySelector("#pd_weight").value.split(".").join(""));
            formData.append('pd_desc', $('#pd_desc').val());
            formData.append('pd_cat_id', ($('#pd_cat_id').val() == null || $('#pd_cat_id').val() == '' ? 0 : $('#pd_cat_id').val()));
            formData.append('is_published', $('#is_published').val() == 'on' ? 1 : 0);
            formData.append('onboarding', $('#onboarding').val() == 'on' ? 1 : 0)
            <?php if (isset($data_id)) { ?>
                formData.append('data_id', <?= $data_id ?>)
            <?php } ?>
        }
    });

    function successins(success = true) {
        if (success) {
            Swal.fire({
                title: 'Berhasil menambah data produk!',
                text: "Tekan ok untuk kembali",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Kembali ke halaman list produk',
                cancelButtonText: "Upload produk lainnya"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }else{
                    window.location.reload();
                }
            });
        } else {
            Swal.fire(
                'Gagal menambah data produk!',
                "Mohon periksa kembali data yang anda input!",
                'error'
            )
        }

    }

    function cekdata() {
        if ($('#pd_name').val() == '' ||
            document.querySelector("#pd_price").value.substr(2).split(",").join("") == '' ||
            document.querySelector("#pd_price").value.split(",").join("") == '' ||
            $('#pd_desc').val() == '' ||
            $('#pd_cat_id').val() == '' ||
            $('#is_published').val() == '') {
            return false;
        }

        return true;
    }

    function send() {
        let data = cekdata();
        if (!data) {
            Swal.fire(
                'Perhatian!',
                'Lengkapi semua data sebelum melanjutkan!',
                'error'
            );
            return;
        }

        let form = $('#pdimg');
        var dzone = document.querySelector("#pdimg").dropzone;
        if (dzone.getQueuedFiles().length > 0) {
            dzone.processQueue();
        } else {
            dzone.uploadFiles([]); //send empty 
        }
    }
</script>
<?= $this->endSection() ?>