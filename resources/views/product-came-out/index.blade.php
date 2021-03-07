@extends('templates.template')

@section('title', 'ADMINISTRATOR')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">


@endsection
@section('page', 'Transaksi Pengadaan Barang')

@section('content')
    <div class="row">
        @if (session('msg'))
            <div class="col-12">
                <div class="alert {!! session('type') !!} alert-dismissible fade show" role="alert">
                    {!! session('msg') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Transaksi Pengadaan Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-sm table-bordered table-striped ">
                            <thead>
                                <tr>
                                    <th>Hari,Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Kuantitas</th>
                                    <th>Divisi/Bagian</th>
                                    <th>User</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Hari,Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Kuantitas</th>
                                    <th>Divisi/Bagian</th>
                                    <th>User</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
        <!-- Modal -->
        <div class="modal fade" id="editProductCameOut" tabindex="-1" aria-labelledby="editProductCameOutLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductCameOutLabel">Pengadaan Ditolak</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-form" action="" method="POST">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="description">Keterangan <sup class="text-danger">*</sup>
                                    </label>

                                    <textarea id="description" name="description" class="form-control" autocomplete="off"
                                        required></textarea>
                                    @error('description')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <p>
                                    <sup class="text-danger">*</sup> <small>Data wajib
                                        diisi.</small>
                                </p>
                                <div class="col-md-12 text-left">
                                    <button type="submit" class="btn btn-warning btn-block rounded-0 px-5">TOLAK</button>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Jquery Loading Overlay -->
    <script src="{{ asset('assets/plugins/jquery-loading-overlay/loadingoverlay.min.js') }}"></script>

    <script src="{{ asset('assets/ajax-post.js') }}"></script>
    <script src="{{ asset('assets/input-date-format.js') }}"></script>

    <script type="text/javascript">
        let data_table;
        // DATA TABEL INITIAL
        function initDataTable() {
            let data_table = $("#example1").DataTable({
                "responsive": false,
                // "responsive": {
                //     "details": true,
                //     "type": 'column'
                // },
                "autoWidth": false,
                "ajax": `{{ route('product-came-out.all') }}`,
                "columns": [{
                    data: 'created_at',
                }, {
                    "data": 'product.name'
                }, {
                    "data": 'stock_quantity'
                }, {
                    "data": 'division.name'
                }, {
                    "data": 'user.name'
                }, {
                    "data": 'description_of_request'
                }, {
                    "data": 'status'
                }, {
                    "data": null
                }],
                "columnDefs": [{
                    'targets': 7,
                    'render': function(data, type, full_row, meta) {
                        if (data.status == 'Proses') {

                            return `<form action="{{ url('/product-came-out') }}/` + data.id +
                                `/aproved" method="post" class="d-inline">` +
                                `@csrf` +
                                `@method('put')` +
                                `<button type="submit" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Setuju">` +
                                `<i class="nav-icon fas fa-check"></i>` +
                                `</button>` +
                                `</form>` +
                                `<button type="button" class="btn btn-danger btn-sm rounded-0 btn-edit ml-1"  data-toggle="modal" data-target="#editProductCameOut" data-toggle="tooltip" data-placement="top" title="Tolak">` +
                                `<i class="nav-icon fas fa-ban"></i>` +
                                `</button>`;
                        } else if (data.status == 'Disetujui') {

                            return `<button type="button" class="btn btn-danger btn-sm rounded-0 btn-edit ml-1"  data-toggle="modal" data-target="#editProductCameOut" data-toggle="tooltip" data-placement="top" title="Tolak">` +
                                `<i class="nav-icon fas fa-ban"></i>` +
                                `</button>`;
                        } else {
                            return `<form action="{{ url('/product-came-out') }}/` + data.id +
                                `/aproved" method="post" class="d-inline">` +
                                `@csrf` +
                                `@method('put')` +
                                `<button type="submit" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Setuju">` +
                                `<i class="nav-icon fas fa-check"></i>` +
                                `</button>` +
                                `</form>`;
                        }
                    }
                }],
                "fnCreatedRow": function(row, data, index) {
                    var options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var date = new Date(data.created_at);
                    $('td', row).eq(0).html(date.toLocaleDateString("id-ID", options));
                    $('td', row).eq(2).html(data.stock_quantity + ' ' + data.product.unit);
                    $('td', row).eq(5).html(data.description_of_request ?? '-');

                    var status = "Diproses";
                    var badge = 'warning';
                    if (data.status == 'Disetujui') {
                        status = "Disetujui";
                        badge = 'success';
                    } else if (data.status == 'Ditolak') {
                        status = "Ditolak";
                        badge = 'danger';
                    }
                    $('td', row).eq(6).html('<span class="badge badge-' + badge + '">' + status + '</span>');
                }

            });

            return data_table;
        }

        $(document).ready(function() {

            data_table = initDataTable();

            // $('#edit-form').on('submit', function(e) {
            //     e.preventDefault();
            //     let url = $(this).attr('action');
            //     $("body").LoadingOverlay("show");
            //     let formData = new FormData();
            //     formData.append('_method', 'put');
            //     formData.append('description', $('#description').val());

            //     let ajax = ajaxPost(url, formData);
            //     ajax.done(function(response) {
            //         $("body").LoadingOverlay("hide", true);
            //         if (response.meta.status == 'error') {
            //             toastr.error(response.meta.message);
            //             console.log(response.data);
            //         } else {
            //             console.log(response);
            //             toastr.success(response.meta.message);
            //             data_table.ajax.reload(null, false);
            //             $('#editProductCameOut').modal('hide');
            //             $('#form').trigger('reset');
            //             $('#editProductCameOut .select2').val("");
            //             $('#editProductCameOut .select2').select2({
            //                 theme: 'bootstrap4'
            //             }).trigger('change');
            //         }
            //     });
            //     ajax.error(function(jqXhr, textStatus, errorThrown) {
            //         $("#body").LoadingOverlay("hide", true);
            //         toastr.error(errorThrown);
            //     });
            // });

            $('#example1 tbody').on('click', '.btn-edit', function() {
                var data = data_table.row($(this).closest("tr")).data();
                $('#edit-form').attr('action', `{{ url('/product-came-out') }}/${data.id}/rejected`);
            });
        });

    </script>
@endsection
