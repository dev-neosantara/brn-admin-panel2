<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="flex items-center space-x-4">
            <a href="<?= base_url('sponsors') ?>" class="flex items-center mr-md-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>&nbspKembali
            </a>
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Sponsor</h6>
        </div>
    </div>
    <div class="card-body">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Judul Event</label>
                        <input type="title" class="form-control form-control-user" id="title" tabindex="0" placeholder="Contoh : PT. Sphonsor Ship..." name="title" value="<?php echo isset($data) && isset($data->title) ? $data->title : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="type">Tipe Acara</label>
                        <select name="type" id="type" class="form-control form-control-user">
                            <option value="">Pilih Tipe Acara!</option>
                            <option value="hut">Acara HUT</option>
                            <option value="kopdar">Acara Kopdar</option>
                            <option value="tour">Acara Tour</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <!-- <textarea name="" id="" ></textarea> -->
                        <textarea cols="30" rows="10" class="form-control form-control-user" id="description" tabindex="0" name="description"><?php echo isset($data) && isset($data->description) ? $data->description : '' ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="text" class="form-control datetimepicker" id="start_date" value="<?= isset($data->start_date) ? $data->start_date : '' ?>" required="required">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="text" class="form-control datetimepicker" id="end_date" value="<?= isset($data->end_date) ? $data->end_date : '' ?>" required="required">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="start_time">Waktu Mulai</label>
                                <input type="text" class="form-control" id="start_time" value="<?= isset($data->start_time) ? $data->start_time : '' ?>" required="required" placeholder="Contoh: 05:30">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat Lengkap</label>
                        <!-- <textarea name="" id="" ></textarea> -->
                        <textarea cols="30" rows="10" class="form-control form-control-user" id="address" tabindex="0" name="address"><?php echo isset($data) && isset($data->address) ? $data->address : '' ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="prov">Provinsi</label>
                                <select name="prov" id="prov" class="form-control form-control-user">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="city">Kota/Kabupaten</label>
                                <select name="city" id="city" class="form-control form-control-user">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="map">Tentukan titik peta</label>
                                <div id="map" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                            <label for="">Gambar Cover</label>
                            <form action="<?= 'https://api.brnjuara.com/api/upload-files' ?>" method="post" class="dropzone" id="pdimg">
                                <!-- <div id="pdimg"></div> -->
                                <div class="dz-message" data-dz-message><span>Klik atau jatuhkan file foto KTP disini!</span></div>
                            </form>
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
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script> -->
<!-- <script src="<?= base_url() ?>/lib/ckeditor/ckeditor.js"></script> -->
<script>
    var lat = 108.495;
    var lng = -6.888;
    var map = L.map('map').setView([lng, lat], 8);
    var marker = new L.Marker(map.getCenter());
    

    marker.addTo(map);
    map.on('moveend', function(e){
        marker.bindTooltip("Lokasi Event").openTooltip();
        // console.log();
        var res = map.getCenter();
        lat = res.lat;
        lng = res.lng;
    });

    map.on('move', function(){
        marker.setLatLng(map.getCenter());
    })
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);
    
    const search = new GeoSearch.GeoSearchControl({
        provider: new GeoSearch.OpenStreetMapProvider(),
    });
    map.addControl(search);
    map.on('click', mapClick);
    function mapClick(e){
        console.log(e.latlng.lat);
        L.marker([10.496093,-66.881935]).addTo(map)
    }
    $('#prov').select2({
        placeholder: 'Pilih ',
        ajax: {
            url: "<?= base_url('extra/get_regions') ?>",
            dataType: 'json',
            data: function(params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }

                // Query parameters will be ?search=[term]&page=[page]
                return query;
            },
            processResults: function(data, params) {
                var dt = $.map(data.data, function(obj) {
                    obj.id = obj.id || obj.pk; // replace pk with your identifier
                    obj.text = obj.text || obj.region;
                    return obj;
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: dt,
                    pagination: {
                        more: (params.page * 10) < data.count_filtered
                    }
                };
            }
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });

    $('#prov').on('select2:select', function(e) {
        var data = e.params.data;
        $('#city').select2({
            ajax: {
                url: "<?= base_url('extra/get_areas') ?>/" + data.id,
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                processResults: function(data, params) {
                    var dt = $.map(data.data, function(obj) {
                        obj.id = obj.id || obj.pk; // replace pk with your identifier
                        obj.text = obj.text || obj.area;
                        return obj;
                    });
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: dt,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
    });
</script>
<script>
    var image = "";
    var start_date = $('#start_date').datepicker({
        startView: 1,
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
                // console.log(date);
                return (d.getMonth() + 1) + "-" + d.getDate() + "-" + d.getFullYear();
            }
        }
    });
    var start_time = new Cleave('#start_time', {
        time: true,
        timePattern: ['h', 'm']
    });
    var end_date = $('#end_date').datepicker({
        startView: 1,
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
                return (d.getMonth() + 1) + "-" + d.getDate() + "-" + d.getFullYear();
            }
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
            sendapi();
            // console.log(response);
        },
        sending: function(file, xhr, formData) {
            formData.append('key', 'freekeetiiw');
            // console.log(formData);
        }
    });

    function sendapi() {
        Toast.fire({
            icon: 'info',
            title: "menyimpan ke database!"
        });
        var params = {
            title: $('#title').val(),
            latitude: lat,
            longitude: lng,
            description: $('#description').val(),
            start_date: $('#start_date').data('datepicker').getFormattedDate('yyyy-mm-dd'),
            end_date: $('#end_date').data('datepicker').getFormattedDate('yyyy-mm-dd'),
            start_time: $('#start_time'),
            type: $('#type').val(),
            address: $('#address').val(),
            area_id: $('#city').val(),
            image: image,
            data_id: null
        };
        <?php if (isset($data_id) && $data_id != null) { ?>
            params['data_id'] = <?= $data_id ?>;
        <?php } ?>
        // console.log(params);return;
        var urls = "<?= base_url('events/insert') ?>";
        axios.post(urls, params)
            .then(function(response) {
                
                if (response.data.error == 0) {
                    successins(true, response.data.message);
                } else {

                    successins(false, response.data.message);
                }

            })
            .catch(function(error) {
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