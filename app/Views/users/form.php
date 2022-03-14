<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.7.3/dist/css/autocomplete.min.css" />

<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah User <?= isset($role) ? strtoupper($role) : '' ?></h6>
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
                                        <option value="male" <?= isset($data) && property_exists($data, 'gender') && $data->gender == 'male' ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="female" <?= isset($data) && property_exists($data, 'gender') && $data->gender == 'female' ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik_ktp">NIK KTP</label>
                                    <input type="text" data-validationurl="<?= base_url('extra/valid_nik') ?>" onblur="validation(this)" data-id="<?= isset($data_id) ? $data_id : '' ?>" class="form-control form-control-user" id="nik_ktp" tabindex="0" placeholder="Masukan nik ktp" name="nik_ktp" value="<?php echo isset($data) && property_exists($data, 'nik_ktp') ? $data->nik_ktp : '' ?>">
                                    <span id="nik_ktp_errors" class="text-red-400"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" data-validationurl="<?= base_url('extra/valid_email') ?>" data-id="<?= isset($data_id) ? $data_id : '' ?>" class="form-control form-control-user" id="email" tabindex="0" placeholder="email@domain.com" name="email" value="<?php echo isset($data) && property_exists($data, 'email') ? $data->email : '' ?>" onblur="validation(this)">
                                    <span id="email_errors" class="text-red-400"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">No HP</label>
                                    <input data-validationurl="<?= base_url('extra/valid_phone/') ?>" data-id="<?= isset($data_id) ? $data_id : '' ?>" minlength="9" type="text" class="form-control form-control-user" id="phone" tabindex="0" placeholder="08xxxx" name="phone" value="<?php echo isset($data) && property_exists($data, 'phone_number') ? $data->phone_number : '' ?>">
                                    <span id="phone_errors" class="text-red-400"></span>
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
                                        <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="01/01/2001">
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
                            <!-- <?php //if (isset($data_id)) { 
                                    ?>
                                <div class="col-md-4 col-sm-12">
                                    <?php //view_cell("\Olshop\Controllers\Product::listimage", ['data_id' => $data_id]) 
                                    ?>
                                </div>
                            <?php //} 
                            ?> -->
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
                            <?php if (isset($role)) { ?>
                                <p><?= strtoupper($role) ?></p>
                            <?php } else { ?>
                                <select name="role" id="role" class="form-control form-control-user">
                                    <option value="">Pilih Role !</option>
                                    <?php if (isset($roles)) {
                                        foreach ($roles as $rol) :
                                    ?>
                                            <option value="<?= $rol->name; ?>" data-name="<?= $rol->name; ?>" <?= isset($role) && $role == $rol->name || (isset($data) && property_exists($data, 'role') && $rol->name == $data->role) ? 'selected' : '' ?>><?= $rol->display_name == '' ? $rol->name : $rol->display_name; ?></option>
                                    <?php endforeach;
                                    } ?>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row" id="administratif">
                    <hr>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="korda">Registrasi ke korwil ?</label>
                            <select name="korda" id="korda" class="form-control form-control-user korda"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="korwil">Registrasi ke korda ?</label>
                            <select name="korwil" id="korwil" class="form-control form-control-user korwil"></select>
                        </div>
                    </div>
                </div>
                <div class="row" id="rentalinfo">
                    <div class="col-md-12 border-b">
                        <h1 class="text-xl">Info Rental</h1>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company_name">Nama Rental</label>
                            <input type="text" class="form-control form-control-user" id="company_name" placeholder="Nama Rental" tabindex="0" name="company_name" value="<?php echo isset($data) && property_exists($data, 'company_name') ? $data->company_name : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="siupsku_number">Nomor Siupsku</label>
                            <input type="text" class="form-control form-control-user" id="siupsku_number" placeholder="Nama Rental" tabindex="0" name="siupsku_number" value="<?php echo isset($data) && property_exists($data, 'company_name') ? $data->company_name : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row" id="addressinfo">
                    <div class="col-md-12 border-b">
                        <h1 class="text-xl">Alamat Rental</h1>
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
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Lokasi Rental User</label>
                                        <div class="auto-search-wrapper loupe">
                                            <input type="text" autocomplete="off" id="search" class="w-full px-2" placeholder="masukan nama kota/daerah">
                                            <div class="auto-results-wrapper">
                                                <ul id="auto-search-results" tabindex="0" role="listbox"></ul>
                                            </div><button class="auto-clear hidden" type="button" aria-label="clear text from input"></button>
                                        </div>
                                        <br>
                                        <div class="map" id="map" style="height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <!-- <div class="row" id="additional">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="siupsku_image">Foto Siupsku</label>
                            <form action="https://api.brnjuara.com/api/upload-files" method="post" class="dropzone" id="siupsku_image">
                                
                                <div class="dz-message" data-dz-message><span>Klik atau jatuhkan file foto SIUPSKU disini!</span></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="garage_image">Foto Siupsku</label>
                            <form action="https://api.brnjuara.com/api/upload-files" method="post" class="dropzone" id="garage_image">
                               
                                <div class="dz-message" data-dz-message><span>Klik atau jatuhkan file foto Garasi disini!</span></div>
                            </form>
                        </div>
                    </div>
                </div> -->
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
                    <button onclick="send()" class="btn btn-primary">Tambah User <?= isset($role) ? strtoupper($role) : "" ?></button>
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
<!-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.7.3/dist/js/autocomplete.min.js"></script>

<script src="<?= base_url('js/map-provider.js') ?>"></script>
<script src="<?= base_url('js/maps.js') ?>"></script>
<!-- master data (edit) -->
<script>
    <?php if (isset($data)) { ?>
        const datauser = <?= json_encode($data) ?>;
    <?php } else { ?>
        var datauser;
    <?php } ?>
</script>
<!-- Custom script for maps -->
<script>
    // custom script for map
    var lat = 108.495;
    var lng = -6.888;
    var map = L.map('map').setView([lng, lat], 8);
    var marker = new L.Marker(map.getCenter());
    marker.addTo(map);
    // var osmGeocoder = new L.Control.OSMGeocoder();

    map.on('moveend', function(e) {
        marker.bindTooltip("Set ini sebagai alamat user").openTooltip();
        // console.log();
        var res = map.getCenter();
        lat = res.lat;
        lng = res.lng;
    });

    map.on('move', function() {
        marker.setLatLng(map.getCenter());
    })
    map.on('locationfound', function() {
        marker.setLatLng(map.getCenter());
    })
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);
</script>
<!-- Geocoding maps -->
<script>
    // geocoding maps
    // minimal configure
    new Autocomplete("search", {
        // default selects the first item in
        // the list of results
        selectFirst: true,

        // The number of characters entered should start searching
        howManyCharacters: 2,

        // onSearch
        onSearch: ({
            currentValue
        }) => {
            // You can also use static files
            // const api = '../static/search.json'
            const api = `https://nominatim.openstreetmap.org/search?format=geojson&limit=5&city=${encodeURI(
      currentValue
    )}`;

            /**
             * jquery
             */
            // return $.ajax({
            //     url: api,
            //     method: 'GET',
            //   })
            //   .done(function (data) {
            //     return data
            //   })
            //   .fail(function (xhr) {
            //     console.error(xhr);
            //   });

            // OR -------------------------------

            /**
             * axios
             * If you want to use axios you have to add the
             * axios library to head html
             * https://cdnjs.com/libraries/axios
             */
            // return axios.get(api)
            //   .then((response) => {
            //     return response.data;
            //   })
            //   .catch(error => {
            //     console.log(error);
            //   });

            // OR -------------------------------

            /**
             * Promise
             */
            return new Promise((resolve) => {
                fetch(api)
                    .then((response) => response.json())
                    .then((data) => {
                        resolve(data.features);
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            });
        },
        // nominatim GeoJSON format parse this part turns json into the list of
        // records that appears when you type.
        onResults: ({
            currentValue,
            matches,
            template
        }) => {
            const regex = new RegExp(currentValue, "gi");

            // if the result returns 0 we
            // show the no results element
            return matches === 0 ?
                template :
                matches
                .map((element) => {
                    return `
          <li class="loupe">
            <p>
              ${element.properties.display_name.replace(
                regex,
                (str) => `<b>${str}</b>`
              )}
            </p>
          </li> `;
                })
                .join("");
        },

        // we add an action to enter or click
        onSubmit: ({
            object
        }) => {
            const {
                display_name
            } = object.properties;
            const cord = object.geometry.coordinates;

            // custom id for marker
            const customId = Math.random();

            // create marker and add to map
            marker = L.marker([cord[1], cord[0]], {
                    title: display_name,
                    id: customId,
                })
                .addTo(map)
                .bindPopup(display_name);

            // sets the view of the map
            map.setView([cord[1], cord[0]], 8);

            let res = map.getCenter();

            lat = res.lat;
            lng = res.lng;

            // removing the previous marker
            // if you want to leave markers on
            // the map, remove the code below
            map.eachLayer(function(layer) {
                if (layer.options && layer.options.pane === "markerPane") {
                    if (layer.options.id !== customId) {
                        map.removeLayer(layer);
                    }
                }
            });
        },

        // get index and data from li element after
        // hovering over li with the mouse or using
        // arrow keys ↓ | ↑
        onSelectedItem: ({
            index,
            element,
            object
        }) => {
            // console.log("onSelectedItem:", index, element, object);
        },

        // the method presents no results element
        noResults: ({
                currentValue,
                template
            }) =>
            template(`<li>No results found: "${currentValue}"</li>`),
    });
</script>

<script>
    var additional = {
        korda: null,
        korwil: null,
        prov: null,
        city: null,
        subdistrict: null,
        phone: null,
        date_of_birth: null,
        data_id: null, role: null
    }
    const baseUrl = "<?= base_url('users') ?>";
    const role = "<?= isset($role) ? $role : (isset($data) && property_exists($data, 'role') ? $data->role : '') ?>";
    var areas = [];
    var subd = [];
    var tahunmasuk = new Date().getFullYear();
    $('#year').val(tahunmasuk);
    var phone = new Cleave('#phone', {
        phone: true,
        phoneRegionCode: 'ID',
        onValueChanged: function(e) {
            let target = document.querySelector('#phone');
            let val = e.target.rawValue.replace("+62", "0");
            validation(target, val);
        }
    });
    var year = new Cleave('#year', {
        date: true,
        delimiter: '-',
        datePattern: ['Y']
    });
    $(document).ready(() => {
        // $('.prov').select2({
        //     placeholder: "Tidak ada data provinsi!"
        // });
        $('.korda').select2({
            placeholder: "Tidak ada data korda!"
        });
        $('.city').select2({
            placeholder: "Pilih provinsi di atas!"
        });
        $('.subdistrict').select2({
            placeholder: "Pilih kota/kab di atas!"
        });

        var provparams = {};
        var subdsparams = {};
        if (datauser != null && datauser.subdistrict != null) {
            subsdsparams['id'] = datauser.subdistrict;
            subdsparams['area_id'] = datauser.city;
            getSubdistrict(subdsparams).then((res) => {
                if (res.data.data.length > 0) {
                    $('.subdistrict').select2({
                        placeholder: "Pilih Kecamatan!",
                        data: res.data.data
                    });
                } else {
                    $('.subdistrict').select2({
                        placeholder: "Tidak ada kecamata untuk kota/kab ini!"
                    });
                }
            })
        }
        if (datauser != null && datauser.state != null) {
            provparams['id'] = datauser.state;
        }

        // var prov = getRegions(provparams);
        getRegions(provparams).then((res) => {
            $('.prov').select2({
                placeholder: 'Pilih provinsi!',
                data: res.data.data
            });
        });
        var cityparams = {};
        if (datauser != null && datauser.state != null) {
            cityparams['region_id'] = datauser.state;
        }
        if (datauser != null && datauser.city != null) {
            cityparams['id'] = parseInt(datauser.city);
            getAreas(cityparams).then((res) => {
                if (res.data.data.length > 0) {
                    $('.city').select2({
                        placeholder: "Pilih Kota/Kab!",
                        data: res.data.data
                    });
                } else {
                    $('.city').select2({
                        placeholder: "Tidak ada kota/kab untuk provinsi ini!"
                    });
                }

            });
        }
        $('.prov').on('select2:select', function(e) {
            var data = e.params.data;
            cityparams['region_id'] = parseInt(data.id);
            getAreas(cityparams).then((res) => {
                if (res.data.data.length > 0) {
                    $('.city').select2({
                        placeholder: "Pilih Kota/Kab!",
                        data: res.data.data
                    });
                } else {
                    $('.city').select2({
                        placeholder: "Tidak ada kota/kab untuk provinsi ini!"
                    });
                }

            });

        });
        $('.city').on('select2:select', function(e) {
            var data = e.params.data;
            // additional.kota = data.id;
            
            subdsparams['area_id'] = parseInt(data.id);
            getSubdistrict(subdsparams).then((res) => {
                if (res.data.data.length > 0) {
                    $('.subdistrict').select2({
                        placeholder: "Pilih Kecamatan!",
                        data: res.data.data
                    });
                } else {
                    $('.subdistrict').select2({
                        placeholder: "Tidak ada kecamata untuk kota/kab ini!"
                    });
                }
            })

        });
        var korwilparams = {}
        korwilparams['is_registerd'] = 1;
        if (datauser != null && datauser.korwil_id != null) {
            korwilparams['id'] = datauser.korwil_id;
        }
        var kordaparams = {};
        kordaparams['is_registered'] = 1;
        if (datauser != null && datauser.korda_id != null) {
            kordaparams['id'] = datauser.korda_id;
        }

        getRegions(korwilparams).then((res) => {
            // console.log(res.data.data);
            if (res.data.data.length > 0) {
                $('.korda').select2({
                    placeholder: "Pilih Wilayah Administrasi!",
                    data: res.data.data
                });
            } else {
                $('.korda').select2({
                    placeholder: "Tidak ada data wilayah yang terdaftar di organisasi!"
                });
            }
        })
        $('.korwil').select2({
            placeholder: "Pilih wilayah administrasi di atas!"
        });
        $('.korda').on('select2:select', function(e) {
            var data = e.params.data;
            kordaparams['region_id'] = parseInt(data.id);
            // additional.korda = data.id;
            console.log(kordaparams);
            getAreas(kordaparams).then((res) => {
                if (res.data.data.length > 0) {
                    $('.korwil').select2({
                        placeholder: "Pilih Daerah Administrasi!",
                        data: res.data.data
                    });
                } else {
                    $('.korwil').select2({
                        placeholder: "Tidak ada data daerah yang terdaftar di organisasi!"
                    });
                }
            });
        });




    });
    // if (datauser != null && datauser.korwil_id != null) {
    //     var defaultKorwil = new Option(datauser.korwil_name, datauser.korwil_id, true, false);
    //     $('.korda').append(defaultKorwil).trigger('change');
    // }
    // if (datauser != null && datauser.korda_id != null) {
    //     var defaultKorda = new Option(datauser.korda_name, datauser.korda_id, true, false);
    //     $('.korwil').append(defaultKorda).trigger('change');
    // }
    // if (datauser != null && datauser.province != null) {
    //     var defaultProv = new Option(datauser.region, datauser.province, true, false);
    //     $('.prov').append(defaultProv).trigger('change');
    // }
    // if (datauser != null && datauser.city != null) {
    //     var defaultCity = new Option(datauser.area, datauser.city, true, false);
    //     $('.city').append(defaultCity).trigger('change');
    // }
    // if (datauser != null && datauser.subdistrict != null) {
    //     var defaultSub = new Option(datauser.subdistrict_name, datauser.subdistrict, true, false);
    //     $('.subdistrict').append(defaultSub).trigger('change');
    // }

    // $('.korwil').on('select2:select', function(e) {
    //     var data = e.params.data;
    //     additional.korwil = data.id;
    // });


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
                // d.setDate(d.getDate());
                return d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
            }
        }
    });

    function sendapi(image = "") {
        if (!cekdata()) {
            return;
        }
        var params = $('#formuser').serializeArray();
        var db = new Date(tgllahir.datepicker('getDate'));
        additional.phone = phone.getRawValue();
        additional.korda = document.querySelector("#korwil").value;
        additional.korwil = document.querySelector("#korda").value;
        additional.prov = document.querySelector("#prov").value;
        additional.city = document.querySelector("#city").value;
        additional.subdistrict = document.querySelector("#subdistrict").value;
        additional.date_of_birth = db.getFullYear() + "-" + (db.getMonth() + 1) + "-" + db.getDate();

        if (image != "") {
            params['profile_photo_path'] = image;
            params['profile_image'] = image;
        }
        <?php if (isset($role)) { ?>
            if(params.hasOwnProperty('role')){
                params['role'] = params['role'] != null ? params['role'] : role;
            }
            additional['role'] = role
            
        <?php } ?>
        <?php if (isset($data_id)) { ?>
            additional['data_id'] = '<?= $data_id ?>'
        <?php } ?>

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
                title: message,
                text: "Tekan ok untuk kembali",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Kembali ke halaman list User',
                cancelButtonText: "Upload User lainnya"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                } else if (!result.isConfirmed) {
                    window.location.reload();
                } else {
                    return;
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
        if ($('#nik_ktp').val() == '') {
            Swal.fire(
                'Perhatian!',
                'NIK tidak boleh kosong!',
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

    function send() {
        let data = cekdata();
        if (data) {
            sendapi();
        }

    }
</script>
<?= $this->endSection() ?>