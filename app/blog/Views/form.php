<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<!-- <link rel="stylesheet" href="<?= PUBLIC_PATH . 'lib/ckeditor/ckeditor.js' ?>toolbarconfigurator/lib/codemirror/neo.css"> -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Artikel</h6>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control form-control-user" id="title" tabindex="0" placeholder="Judul" name="title" value="<?php echo isset($data) && isset($data->title) ? $data->title : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="contentarticle">Konten</label>
                        <textarea name="contentarticle" id="contentarticle" class="border rounded-md p-2" cols="30" rows="10" tabindex="1"><?php echo isset($data) && isset($data->content) ? $data->content : '' ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-4 pr-2">
                <?php if (isset($data_id) && $data->image != null && $data->image != "") { ?>
                    <div class="col-md-12">
                        <img src="<?= base_url($data->image) ?>" alt="gambar cover">
                    </div>
                <?php } ?>
                <div class="col-md-12">
                    <label for="">Foto Cover</label>
                    <form action="<?= base_url('/blog/article/upload/json') ?>" method="post" class="dropzone" id="pdimg">
                        <!-- <div id="pdimg"></div> -->
                        <div class="dz-message" data-dz-message><span>Klik atau jatuhkan file foto Artikel disini!</span></div>
                    </form>
                </div>
               
            </div>
                    
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="is_published" <?php echo isset($data) && (int)$data->status == 'published' ? "checked" : '' ?>>
                            <label class="custom-control-label" for="is_published">Publish Artikel ini? (jika iya, maka Artikel akan langsung terlihat)</label>
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
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script> -->
<script src="<?= base_url() ?>/lib/ckeditor/ckeditor.js"></script>
<script>
    var contentdata = "";
    Dropzone.autoDiscover = false;
    var image = "";

    function sendapi() {
        Toast.fire({
            icon: 'info',
            title: "menyimpan ke database!"
        });
        var params = {
            title: $('#title').val(),
            content: contentdata.getEditor().getData(),
            category: 1,
            status: $('#is_published').val() == 'on' ? "published" : "draft",
            image: image,
            data_id: null
        };
        <?php if(isset($data_id) && $data_id != null){ ?>
            params['data_id'] = <?= $data_id ?>;
            <?php } ?>
        // console.log(params);return;
        var urls = "<?= base_url('blog/article/insert') ?>";
        axios.post(urls, params)
            .then(function(response) {
                if (response.data.error == 0) {
                    successins(true, response.data.message);
                } else {

                    successins(false, response.data.message);
                }

            })
            .catch(function(error) {
                // image = images;
                console.log(error);
                successins(false, error);
            });
    }

    var ds = $("#pdimg").dropzone({
        paramName: "pd_img", // The name that will be used to transfer the file
        maxFilesize: 10, // MB
        autoProcessQueue: false,
        multiple: false,
        accept: function(file, done) {
            if (done) {
                done();
            }
        },
        success: function(response) {
            // console.log();
            let data = JSON.parse(response.xhr.responseText);
            image = data.images[0];
            sendapi();
        },
        error: function() {
            // successins(false)
            Swal.fire({
                title: 'Gagal mengupload gambar cover',
                text: "Gagal mengupload gambar cover, tetap simpan data?",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ya! simpan data tanpa gambar cover',
                cancelButtonText: "Tidak!"
            }).then((result) => {
                if (result.isConfirmed) {
                    sendapi()
                }
            });
        }
    });

    function successins(success = true) {
        if (success) {
            Swal.fire({
                title: 'Berhasil menambah data Artikel!',
                text: "Tekan ok untuk kembali",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Kembali ke halaman list Artikel',
                cancelButtonText: "Upload Artikel lainnya"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                } else {
                    window.location.reload();
                }
            });
        } else {
            Swal.fire(
                'Gagal menambah data Artikel!',
                "Mohon periksa kembali data yang anda input!",
                'error'
            )
        }

    }

    function cekdata() {
        if ($('#title').val() == '' || contentdata.getEditor().getData() == '') {
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
            sendapi();
        }
    }
</script>
<script>
    /**
     * Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
     * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
     */

    /* exported initSample */

    if (CKEDITOR.env.ie && CKEDITOR.env.version < 9)
        CKEDITOR.tools.enableHtml5Elements(document);

    // The trick to keep the editor in the sample quite small
    // unless user specified own height.
    CKEDITOR.config.height = 150;
    CKEDITOR.config.width = 'auto';
    CKEDITOR.config.extraPlugins = 'filebrowser';
    CKEDITOR.config.extraPlugins = 'filetools';
    CKEDITOR.config.extraPlugins = 'popup';
    CKEDITOR.config.filebrowserBrowseUrl = '/browser/browse.php';
    CKEDITOR.config.filebrowserUploadUrl = '/uploader/upload.php';
    var initSample = (function() {
        // console.log($('#contentarticle'));
        var wysiwygareaAvailable = isWysiwygareaAvailable(),
            isBBCodeBuiltIn = !!CKEDITOR.plugins.get('bbcode');

        return function() {
            var editorElement = CKEDITOR.document.getById('contentarticle');
            
            // :(((
            if (isBBCodeBuiltIn) {
                editorElement.setHtml(
                    'Hello world!\n\n' +
                    'I\'m an instance of [url=https://ckeditor.com]CKEditor[/url].'
                );
            }

            // Depending on the wysiwygarea plugin availability initialize classic or inline editor.
            if (wysiwygareaAvailable) {
                CKEDITOR.replace('contentarticle');
            } else {
                editorElement.setAttribute('contenteditable', 'true');
                CKEDITOR.inline('contentarticle');

                // TODO we can consider displaying some info box that
                // without wysiwygarea the classic editor may not work.
            }

            contentdata = editorElement;
        };

        function isWysiwygareaAvailable() {
            // If in development mode, then the wysiwygarea must be available.
            // Split REV into two strings so builder does not replace it :D.
            if (CKEDITOR.revision == ('%RE' + 'V%')) {
                return true;
            }

            return !!CKEDITOR.plugins.get('wysiwygarea');
        }
    })();

    $(document).ready(() => {
        initSample();
    });
</script>
<?= $this->endSection() ?>