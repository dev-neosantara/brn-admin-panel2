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
            <a href="<?= base_url('events') ?>" class="flex items-center mr-md-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>&nbspKembali
            </a>
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data events</h6>
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
                            <option value="hut" <?php echo isset($data) && isset($data->type) && $data->type == 'HUT' ? 'selected' : '' ?>>Acara HUT</option>
                            <option value="kopdar" <?php echo isset($data) && isset($data->type) && $data->type == 'KOPDAR' ? 'selected' : '' ?>>Acara Kopdar</option>
                            <option value="tour" <?php echo isset($data) && isset($data->type) && $data->type == 'TOUR' ? 'selected' : '' ?>>Acara Tour</option>
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
                    <?php if (isset($data_id) && isset($data->image)) { ?>
                        <div class="form-group">
                            <label for=""></label>
                            <img src="<?= isset($data->image) ? base_url($data->image) : '' ?>" alt="" srcset="">
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="">Gambar Cover</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="active" <?php //echo isset($data) && (int)$data->active == 1 ? "checked" : '' 
                                                                                            ?>>
                            <label class="custom-control-label" for="active">events aktif? (jika iya, maka events akan terlihat di aplikasi)</label>
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
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script> -->
<!-- <script src="<?= base_url() ?>/lib/ckeditor/ckeditor.js"></script> -->

<script>
    <?php if (isset($data)) { ?>
        const dataevent = <?= json_encode($data) ?>;
    <?php } else { ?>
        var dataevent;
    <?php } ?>
</script>
<script>
    // custom script for map
    var lat = dataevent != null && dataevent.latitude != null ? dataevent.latitude : 108.495;
    var lng = dataevent != null && dataevent.longitude != null ? dataevent.longitude : -6.888;
    var map = L.map('map').setView([lng, lat], 8);
    var marker = new L.Marker(map.getCenter());
    marker.addTo(map);
    // var osmGeocoder = new L.Control.OSMGeocoder();

    map.on('moveend', function(e) {
        marker.bindTooltip("Set ini sebagai alamat agenda").openTooltip();
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
    var provparams = {};
    var cityparams = {};
    $(document).ready(() => {
        if (dataevent != null && dataevent.area_id != null) {
            provparams['area_id'] = dataevent.area_id;
            cityparams['id'] = dataevent.area_id;
            getAreas(cityparams).then((res) => {
                $('#city').select2({
                    placeholder: 'Pilih Kota!',
                    data: res.data.data
                });
            });
        }
        getRegions(provparams).then((res) => {
                $('#prov').select2({
                    placeholder: 'Pilih provinsi!',
                    data: res.data.data
                });
            });

            
        $('#prov').on('change.select2', function(e) {
            // var data = e.params.data;
            cityparams['region_id'] = this.value;
            getAreas(cityparams).then((res) => {
                $('#city').select2({
                    placeholder: 'Pilih Kota!',
                    data: res.data.data
                });
            });
            
        });
    })

    // if (dataevent != null && dataevent.korwil_id != null) {
    //     var defaultProv = new Option(datauser.korwil_name, datauser.korwil_id, true, false);
    //     $('#prov').append(defaultKorwil).trigger('change');
    // }
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
            start_time: $('#start_time').val(),
            type: $('#type').val(),
            address: $('#address').val(),
            area_id: $('#city').val(),
            image: $('input[type=file]').get(0).files[0],
            data_id: null
        };

        <?php if (isset($data_id) && $data_id != null) { ?>
            params['data_id'] = <?= $data_id ?>;
        <?php } ?>
        var datas = new FormData();
        for (var key in params) {
            datas.append(key, params[key]);
        }
        // console.log(params);return;
        var urls = "<?= base_url('events/insert') ?>";
        axios({
                url: urls,
                method: "post",
                data: datas,
                headers: {
                    "Content-Type": "multipart/form-data"
                },
            })
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
                confirmButtonText: 'Kembali ke halaman Agenda',
                cancelButtonText: "Tambah agenda lainnya"
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
                'Nama events/Perusahaan Tidak boleh kosong!',
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
        sendapi();
    }
</script>

<?= $this->endSection() ?>