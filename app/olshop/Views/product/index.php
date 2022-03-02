<?= $this->extend('App\Views\templateiframe') ?>
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
<div class="card mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="productTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Display Onboarding?</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Display Onboarding?</th>
                        <th>Published</th>
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
    $(document).ready(function() {
        $('#productTable').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            order: [], //init datatable not ordering
            ajax: "<?php echo site_url('olshop/product/list') ?>",
            buttons: {
                buttons: [
                    `<a href="<?= route_to('add_product') ?>" class="btn btn-primary btn-sm flex inline"><i class="fas fa-plus"></i>&nbsp;Tambah Produk</a>`
                ]
            },
            columnDefs: [{
                    targets: 0,
                    orderable: false
                },
                {
                    targets: 5,
                    render: function(data, type, full, meta) {
                        console.log(full);
                        let pubclass = full[4] == 1 ? "btn-danger" : "btn-success";
                        let pubmsg = full[4] == 1 ? "Unpublish" : "Publish";
                        let pubicon = full[4] == 1 ? "fa-chevron-down" : "fa-chevron-up";
                        if (type === 'display') {
                            data = `<a title="Edit produk ini" class="btn btn-primary" href="<?= base_url('olshop/product/edit') ?>/` + data + `">
                                    <i class="fas fa-pencil-alt"></i>
                                <span></span>
                            </a>
                            <a title="Hapus produk ini" class="btn btn-danger" href="#" onclick="deletepro('` + full[1] + `', ` + full[5] + `)">
                                    <i class="fas fa-trash"></i>
                                <span></span>
                            </a>
                            <a title="Unpublished produk ini" class="btn `+ pubclass +`" href="#" onclick="publish('` + full[1] + `', ` + full[5] + `)">
                                    <i class="fas `+ pubicon +`"></i>
                                <span>`+ pubmsg +`</span>
                            </a>`
                        }
                        return data;
                    }
                },
                {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        if (type === 'display') {
                            if (data == 0) {
                                data = `<i class="fas fa-window-close fa-2x" style="color:red"></i>`;
                            } else if (data == 1) {
                                data = `<i class="fas fa-check-square fa-2x" style="color:green"></i>`;
                            }

                        }
                        return data;
                    }
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        if (type === 'display') {
                            if (data == 0) {
                                data = `<i class="fas fa-window-close fa-2x" style="color:red"></i>`;
                            } else if (data == 1) {
                                data = `<i class="fas fa-check-square fa-2x" style="color:green"></i>`;
                            }

                        }
                        return data;
                    }
                }
            ]

        });

        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            console.log(message);
        };
    });

    function createManageBtn() {
        return '<button id="manageBtn" type="button" onclick="myFunc()" class="btn btn-success btn-xs">Manage</button>';
    }

    function myFunc() {
        console.log("Button was clicked!!!");
    }

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
    function deletepro(name, id) {
        const url = "<?= base_url('olshop/product/delete') ?>/" + id;
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Anda akan menghapus produk " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus produk ini!'
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