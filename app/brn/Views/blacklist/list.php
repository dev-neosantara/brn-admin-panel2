<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<!-- Custom styles for this page -->
<!-- <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/r-2.2.9/rg-1.1.4/sc-2.0.5/sp-1.4.0/datatables.min.css" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Data Produk</h1> -->
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Blacklist</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="blacklistTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK KTP</th>
                        <th>Foto</th>
                        <th>Penginput</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK KTP</th>
                        <th>Foto</th>
                        <th>Penginput</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('foot') ?>
<!-- Page level custom scripts -->
<!-- <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/r-2.2.9/rg-1.1.4/sc-2.0.5/sp-1.4.0/datatables.min.js"></script>

<script>
    const API_BASE_URL = "https://api.brnjuara.com/storage";
    $(document).ready(function() {
        $('#blacklistTable').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            order: [], //init datatable not ordering
            ajax: "<?php echo site_url('blacklist/list') ?>",
            buttons: {
                buttons: [
                    `<a href="<?= route_to('add_blacklist') ?>" class="border bg-blue-500 text-white px-2 py-1 rounded-md flex space-x-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg><span>Tambah Data Pelaku</span></a>`
                ]
            },
            columnDefs: [{
                    targets: 0,
                    orderable: false
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        let res = full[4];
                        if (type === 'display') {
                            if(res == "" || res == null){
                                return "Admin";
                            }
                        }
                        return res;
                    }
                },
                {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        let res = "";
                        if (type === 'display' && full[3] != null) {
                            res += `<a href="${API_BASE_URL}/${full[3]}" target="_blank" class="underline flex space-x-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>Lihat</a>`;
                        }
                        return res;
                    }
                },
                {
                    targets: 5,
                    render: function(data, type, full, meta) {
                        let res = "";
                        if (type === 'display') {
                            res += `<a href="<?= base_url('blacklist/edit') ?>/${full[5]}" class="flex space-x-2 border rounded-lg bg-green-500 text-center text-white justify-center items-center py-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>Edit</a>`;
                                res += `<a href="#" onclick="deletepro(${full[5]})" class="flex space-x-2 border rounded-lg bg-red-400 text-center text-white justify-center items-center py-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>Hapus</a>`;
                        }
                        return res;
                    }
                }
            ]

        });

        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            console.log(message);
        };
    });

    function publish(name, id) {
        const url = "<?= base_url('olshop/product/publish') ?>/" + id;
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Anda akan mempublish produk " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, publish produk ini!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error == 0) {
                            Swal.fire(
                                'Published!',
                                data.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });

                            return;
                        }
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    });

            }
        })
    }

    function deletepro(id) {
        const url = "<?= base_url('blacklist/hapus') ?>/" + id;
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Anda akan menghapus data ini? ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus data pelaku ini!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error == 0) {
                            Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });

                            return;
                        }
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    });

            }
        })
    }
</script>
<?= $this->endSection() ?>