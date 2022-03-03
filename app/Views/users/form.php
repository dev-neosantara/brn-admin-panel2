<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<!-- <link rel="stylesheet" href="<?= ROOTPATH.'node_modules/dropzone.css' ?>"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah User</h6>
    </div>
    <div class="card-body">
        <div class="container">
            <form id="formuser" action="#" method="post">
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
                                    <label for="name">Gender</label>
                                    <select name="gender" id="gender" class="form-control form-control-user">
                                        <option value="">Pilih Jenis Kelamin Anda!</option>
                                        <option value="male" <?= isset($data) && property_exists($data, 'gender') && $data->name == 'male' ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="female" <?= isset($data) && property_exists($data, 'gender') && $data->name == 'female' ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik_ktp">NIK KTP</label>
                                    <input type="text" data-validationurl="<?= base_url('extra/valid_nik') ?>" onblur="validation(this)" class="form-control form-control-user" id="nik_ktp" tabindex="0" placeholder="Masukan nik ktp" name="nik_ktp" value="<?php echo isset($data) && property_exists($data, 'nik_ktp') ? $data->nik_ktp : '' ?>">
                                    <span id="nik_ktp_errors" class="text-red-400"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" data-validationurl="<?= base_url('extra/valid_email') ?>" class="form-control form-control-user" id="email" tabindex="0" placeholder="email@domain.com" name="email" value="<?php echo isset($data) && property_exists($data, 'email') ? $data->email : '' ?>" onblur="validation(this)">
                                    <span id="email_errors" class="text-red-400"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">No HP</label>
                                    <input data-validationurl="<?= base_url('extra/valid_phone') ?>" minlength="9" maxlength="13" type="text" class="form-control form-control-user" id="phone_number" tabindex="0" placeholder="08xxxx" name="phone_number" value="<?php echo isset($data) && property_exists($data, 'phone_number') ? $data->phone_number : '' ?>">
                                    <span id="phone_number_errors" class="text-red-400"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="place_of_birth">Tempat Lahir</label>
                                    <input type="text" class="form-control form-control-user" id="place_of_birth" tabindex="0" name="place_of_birth" value="<?php echo isset($data) && property_exists($data, 'place_of_birth') ? $data->place_of_birth : '' ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth">Tgl Lahir</label>
                                    <div class="input-group date tgllahir" data-provide="datepicker">
                                        <input type="text" class="form-control" id="date_of_birth" placeholder="01/01/2001">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year">Tahun Masuk</label>
                                    <input type="text" class="form-control form-control-user" id="year" tabindex="0" name="year" value="<?php echo isset($data) && property_exists($data, 'year_approved') ? $data->year_approved : '' ?>">
                                </div>
                            </div>
                            <!-- <?php //if (isset($data_id)) { ?>
                                <div class="col-md-4 col-sm-12">
                                    <?php //view_cell("\Olshop\Controllers\Product::listimage", ['data_id' => $data_id]) ?>
                                </div>
                            <?php //} ?> -->
                            <!-- <div class="col-md-4 col-sm-12">
                            <label for="">Foto Profile</label>
                            <form action="https://api.brnjuara.com/api/upload-files" method="post" class="dropzone" id="pdimg"> -->
                            <!-- <div id="pdimg"></div> -->
                            <!-- <div class="dz-message" data-dz-message><span>Klik atau jatuhkan file foto Artikel disini!</span></div> -->
                            <!-- </form>
                        </div> -->
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
                                    foreach ($roles as $rol) :
                                ?>
                                        <option value="<?= $rol->id; ?>" data-name="<?= $rol->name; ?>" <?= isset($role) && $role == $rol->name ? 'selected' : '' ?>><?= $rol->display_name == '' ? $rol->name : $rol->display_name; ?></option>
                                <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="korda">Registrasi ke korda ?</label>
                            <select name="korda" id="korda" class="form-control form-control-user korda"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="korwil">Registrasi ke korwil ?</label>
                            <select name="korwil" id="korwil" class="form-control form-control-user korwil"></select>
                        </div>
                    </div>
                </div>
                <div class="row" id="addressinfo">
                    <div class="col-md-12 border-b">
                        <h1 class="text-xl">Alamat</h1>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="prov">Provinsi</label>
                                            <select name="prov" id="prov" class="form-control form-control-user prov"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="city">Kota/Kab</label>
                                            <select name="city" id="city" class="form-control form-control-user city"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subdistrict">Kecamatan</label>
                                            <select name="subdistrict" id="subdistrict" class="form-control form-control-user subdistrict"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="postal_code">Kode POS</label>
                                            <input type="number" class="form-control form-control-user" id="postal_code" tabindex="0" placeholder="Kode POS" name="postal_code" value="<?php echo isset($data) && property_exists($data, 'postal_code') ? $data->postal_code : '' ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="postal_code">Alamat Lengkap</label>
                                    <textarea name="address" id="address" cols="30" rows="10" class="form-control form-control-user"></textarea>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="map" id="map" style="height: 400px;"></div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row" id="retalinfo">

                </div>
            </form>
            <div class="row mt-10">
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
                    <button onclick="sendapi()" class="btn btn-primary">Tambah User <?= isset($role) ? strtoupper($role) : "" ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('foot') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/addons/cleave-phone.id.js" integrity="sha512-U479UBH9kysrsCeM3Jz6aTMcWIPVpmIuyqbd+KmDGn6UJziQQ+PB684TjyFxaXiOLRKFO9HPVYYeEmtVi/UJIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script> -->
<!-- <script src="<?= base_url('js/map-provider.js') ?>"></script> -->
<!-- <script src="<?= base_url('js/maps.js') ?>"></script> -->
<script>
    var additional = {
        korda: null,
        korwil: null,
        prov: null,
        kota: null,
        kec: null,
        phone: null
    }
    // var zoomLevel = 3;
    // var mapCenter = [92.76481, -11.60655];
    // var mapCenter2 = [141.0217, 6.519293];
    // var southWest = L.latLng(mapCenter2),
    //     northEast = L.latLng(mapCenter),
    //     bounds = L.latLngBounds(southWest, northEast);
    // var map = L.map('map', {
    //     center: mapCenter,
    //     zoom: zoomLevel
    // });
    // map.fitBounds(mapCenter, mapCenter2);
    // L.tileLayer('https://{s}.tile.openstreetmap.org/' + formatted + '.png', {
    //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    //     subdomains: ['a', 'b', 'c']
    // }).addTo(map);
    // mapbox://styles/renaldimedia/cl04undvd000714oa3kc35e72
    // https://api.mapbox.com/styles/v1/renaldimedia/cl04uwkh7000514mouzj5uwzv.html?title=view&access_token=pk.eyJ1IjoicmVuYWxkaW1lZGlhIiwiYSI6ImNqbng1ZncxNzA4b2Qzd214dWF6Ym9zOW4ifQ.zyBxgpZK_g5dl66zc28u5Q&zoomwheel=true&fresh=true#4.09/-2.41/118.67
    // L.tileLayer.provider('MapBox', {
    //     id: 'renaldimedia/cl04undvd000714oa3kc35e72',
    //     accessToken: 'pk.eyJ1IjoicmVuYWxkaW1lZGlhIiwiYSI6ImNqbng1ZncxNzA4b2Qzd214dWF6Ym9zOW4ifQ.zyBxgpZK_g5dl66zc28u5Q'
    // }).addTo(map);
    const baseUrl = "<?= base_url('users') ?>";
    const role = "<?= isset($role) ? $role : '' ?>";
    var areas = [];
    var subd = [];
    var tahunmasuk = new Date().getFullYear();
    $('#year').val(tahunmasuk);
    var phone = new Cleave('#phone_number', {
        phone: true,
        phoneRegionCode: 'ID',
        onValueChanged: function (e) {
            let target = document.querySelector('#phone_number');
            let val = e.target.rawValue.replace("+62", "0");
            validation(target, val);
        }
    });
    var year = new Cleave('#year', {
        date: true,
        delimiter: '-',
        datePattern: ['Y']
    });
    $('.korwil').select2();
    $('.prov').select2({
        placeholder: "Tidak ada data provinsi!"
    });
    $('.city').select2({
        placeholder: "Pilih provinsi di atas!"
    });
    $('.subdistrict').select2({
        placeholder: "Pilih kota/kab di atas!"
    });
    $('.prov').select2({
        placeholder: 'Pilih provinsi!',
        ajax: {
            url: "<?= base_url('extra/regions') ?>",
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
            },
            success: function(data) {
                console.log(data.data);
                if (data.data.length == 0) {
                    $('.prov').select2({
                        placeholder: "Tidak ada data provinsi!"
                    });
                }
            }
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });
    $('.prov').on('select2:select', function(e) {
        var data = e.params.data;
        additional.prov = data.id;
        $('.city').select2({
            ajax: {
                url: "<?= base_url('extra/areas') ?>/" + data.id,
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
                },
                success: function(data) {
                    console.log(data.data);
                    if (data.data.length == 0) {
                        $('.city').select2({
                            placeholder: "Tidak ada data kota/kab!"
                        });
                    }
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
    });
    $('.city').on('select2:select', function(e) {
        var data = e.params.data;
        additional.kota = data.id;
        $('.subdistrict').select2({
            ajax: {
                url: "<?= base_url('extra/subdistrict') ?>/" + data.id,
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
                        obj.text = obj.text || obj.subdistrict_name;
                        return obj;
                    });
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: dt,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                },
                success: function(data) {
                    console.log(data.data);
                    if (data.data.length == 0) {
                        $('.subdistrict').select2({
                            placeholder: "Tidak ada data kecamatan!"
                        });
                    }
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
    });
    $('.subdistrict').on('select2:select', function(e) {
        var data = e.params.data;
        additional.kec = data.id;
    });
    $('.korda').select2({
        placeholder: 'Pilih ',
        ajax: {
            url: "<?= base_url('extra/regions/1') ?>",
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
    $('.korda').on('select2:select', function(e) {
        var data = e.params.data;
        additional.korda = data.id;
        $('.korwil').select2({
            ajax: {
                url: "<?= base_url('extra/areas') ?>/" + data.id + "/1",
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
    $('.korwil').on('select2:select', function(e) {
        var data = e.params.data;
        additional.korwil = data.id;
    });
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

    function sendapi(image = "") {
        if(!cekdata()){
            return;
        }
        var params = $('#formuser').serializeArray();
        // params = params.concat(additional);
        additional.phone = phone.getRawValue();
        params['phone_number'] = phone.getRawValue();
        params = params.reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        params = {
            ...params,
            ...additional
        };
        // console.log();return;
        var urls = "<?= base_url('/users/tambah') ?>";
        axios.post(urls, params)
            .then(function(response) {
                console.log(response.data);
                // var data = JSON.parse(response);
                // console.log(data);

                if (response.data.error == 0) {
                    successins(true, response.data.message);
                } else {
                    successins(false, response.data.message);
                }

            })
            .catch(function(error) {
                console.log(error);
                successins(false, error.message);
            });
    }

    function successins(success = true, message = "Mohon periksa kembali data yang anda input!") {
        console.log(typeof message);
        if (typeof message == 'object') {
            message = Object.keys(message).map(function(key) {
                return message[key];
            });
            message = message[0];
        }
        if (success) {
            Swal.fire({
                title: 'Berhasil menambah data User!',
                text: "Tekan ok untuk kembali",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Kembali ke halaman list User',
                cancelButtonText: "Upload User lainnya"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                } else {
                    window.location.reload();
                }
            });
        } else {
            Swal.fire(
                'Gagal menambah data User!',
                message,
                'error'
            )
        }

    }

    function cekdata() {


        if ($('#name').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Nama tidak boleh kosong!',
                'error'
            );
            return false;
        }
        if ($('#gender').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Pilih gender!',
                'error'
            );
            return false;
        }
        if ($('#email').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Email tidak boleh kosong!',
                'error'
            );
            return false;
        }

        if (phone.getRawValue() == '') {
            Swal.fire(
                'Perhatian!',
                'No Hp tidak boleh kosong!',
                'error'
            );
            return false;
        }
        if (year.getRawValue() == '') {
            Swal.fire(
                'Perhatian!',
                'Tahun masuk akan diisi otomatis tahun ' + tahunmasuk,
                'warning'
            );
            return false;
        }
        if ($('#korda').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Korda tidak boleh kosong!',
                'error'
            );
            return false;
        }
        if ($('#korwil').val() == '') {
            Swal.fire(
                'Perhatian!',
                'Korwil tidak boleh kosong!',
                'error'
            );
            return false;
        }
        if (role == '') {
            Swal.fire(
                'Perhatian!',
                'Role/Jabatan tidak boleh kosong!',
                'error'
            );
            return false;
        }


        return true;
    }

    // function send() {
    //     let data = cekdata();
    //     if (data) {
    //         let form = $('#pdimg');
    //         var dzone = document.querySelector("#pdimg").dropzone;
    //         if (dzone.getQueuedFiles().length > 0) {
    //             dzone.processQueue();
    //         } else {
    //             dzone.uploadFiles([]); //send empty 
    //         }
    //     }

    // }
</script>
<?= $this->endSection() ?>