@extends('templates.template')

@section('title', 'ADMINISTRATOR')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


@endsection
@section('page', 'Transaksi Barang Masuk')

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
                    <h3 class="card-title">Data Transaksi Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
                        <div class="row mb-3">
                            <div class="col-12">
                                <button class="btn btn-primary btn-sm rounded-0" data-toggle="modal"
                                    data-target="#createIncomingProduct">
                                    <i class="fas fa-plus"></i>
                                    TAMBAH</button>
                                <!-- Modal -->
                                <div class="modal fade" id="createIncomingProduct" tabindex="-1"
                                    aria-labelledby="createIncomingProductLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createIncomingProductLabel">Tambah Transaksi
                                                    Barang</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form" action="{{ route('incoming-product.post') }}"
                                                    method="POST">
                                                    {{-- @csrf --}}
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="created_at">Tanggal <sup
                                                                    class="text-danger">*</sup></label>
                                                            <input type="date" id="created_at" name="created_at"
                                                                value="{{ old('created_at') ?? date('Y-m-d') }}"
                                                                class="form-control" required>
                                                            @error('created_at')
                                                                <span>
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label for="division">Barang <sup
                                                                    class="text-danger">*</sup></label>
                                                            <select id="product_id" name="product_id"
                                                                class="form-control select2" required>
                                                                <option value="">Pilih Barang</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}">
                                                                        {{ $product->name }} |
                                                                        {{ $product->unit }}</option>
                                                                @endforeach
                                                            </select>
                                                            <!-- /.form-group -->
                                                            @error('product_id')
                                                                <span>
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-12 form-group">
                                                            <label for="stock">Kuantitas <sup class="text-danger">*</sup>
                                                            </label>

                                                            <input type="number" id="stock" name="stock"
                                                                value="{{ old('stock') }}" class="form-control"
                                                                autocomplete="off" required>
                                                            @error('stock')
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
                                                            <button type="submit"
                                                                class="btn btn-success rounded-0 px-5">SIMPAN</button>
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <table id="example1" class="table table-sm table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>Hari,Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Kuantitas</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
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
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
        <!-- Modal -->
        <div class="modal fade" id="editIncomingProduct" tabindex="-1" aria-labelledby="editIncomingProductLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editIncomingProductLabel">Ubah Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-form" action="" method="POST">
                            {{-- @csrf --}}
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="edit_created_at">Tanggal <sup class="text-danger">*</sup></label>
                                    <input type="date" id="edit_created_at" name="edit_created_at"
                                        value="{{ old('edit_created_at') ?? date('Y-m-d') }}" class="form-control"
                                        required>
                                    @error('edit_created_at')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="edit_product_id">Barang <sup class="text-danger">*</sup></label>
                                    <select id="edit_product_id" name="edit_product_id" class="form-control select2"
                                        required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} |
                                                {{ $product->unit }}</option>
                                        @endforeach
                                    </select>
                                    <!-- /.form-group -->
                                    @error('edit_product_id')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="edit_stock">Kuantitas <sup class="text-danger">*</sup>
                                    </label>

                                    <input type="number" id="edit_stock" name="edit_stock"
                                        value="{{ old('edit_stock') }}" class="form-control" autocomplete="off" required>
                                    @error('edit_stock')
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
                                    <button type="submit" class="btn btn-success btn-block rounded-0 px-5">SIMPAN</button>
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
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Jquery Input Mask -->
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    <script src="{{ asset('assets/ajax-post.js') }}"></script>
    <script src="{{ asset('assets/input-date-format.js') }}"></script>

    <script type="text/javascript">
        let data_table;
        // DATA TABEL INITIAL
        function initDataTable() {
            let data_table = $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ajax": `{{ route('incoming-product.all') }}`,
                "columns": [{
                    data: 'created_at',
                }, {
                    "data": 'product.name'
                }, {
                    "data": 'stock_quantity'
                }, {
                    "data": null
                }, {
                    "data": null
                }, {
                    "data": null
                }],
                "columnDefs": [{
                    'targets': 5,
                    'render': function(data, type, full_row, meta) {
                        return `<button type="button" class="btn btn-warning btn-sm rounded-0 btn-edit"  data-toggle="modal" data-target="#editIncomingProduct">` +
                            `<i class="fas fa-edit"></i> UBAH` +
                            `</button>` +
                            `<button class="btn btn-sm btn-danger rounded-0 btn-delete ml-1">` +
                            `<i class="fas fa-trash"></i>HAPUS` +
                            `</button>`;
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
                    $('td', row).eq(3).html(new Intl.NumberFormat('id-ID', {
                        // maximumSignificantDigits: 0,
                        style: 'currency',
                        currency: 'IDR'
                    }).format(data.product.unit_price));
                    $('td', row).eq(4).html(new Intl.NumberFormat('id-ID', {
                        // maximumSignificantDigits: 0,
                        style: 'currency',
                        currency: 'IDR'
                    }).format(data.total));
                }

            });
            let current_userID = `{{ Auth::user()->division_id }}`;
            if (current_userID != 1 && current_userID != 2) {
                data_table.column(5).visible(false);
            }

            //  }
            return data_table;
        }

        //  Confirmation alert to delete product
        function custom_confirm(data) {
            Swal.fire({
                title: `Anda yakin ingin menghapus ${data.product.name} ?`,
                text: 'Transaksi yang dihapus tidak dapat dikembalikan.',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: `Ya, Hapus`,
                cancelButtonText: `Batal`,
                confirmButtonColor: `#c92434`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value) {
                    $("body").LoadingOverlay("show");
                    let form = new FormData();
                    form.append('_token', '{{ csrf_token() }}');
                    form.append('_method', 'delete');

                    let ajax = ajaxPost(`{{ url('/incoming-product') }}/${data.id}/delete`, form);
                    ajax.done(function(response) {
                        $("body").LoadingOverlay("hide", true);
                        if (response.meta.status == 'error') {
                            toastr.error(response.meta.message);
                        } else {
                            toastr.success(response.meta.message);
                            data_table.ajax.reload(null, false);
                        }
                    })
                }
            })
        }

        $(document).ready(function() {

            data_table = initDataTable();

            $('#form').on('submit', function(e) {
                e.preventDefault();
                $("body").LoadingOverlay("show");
                let formData = new FormData();
                formData.append('created_at', $('#created_at').val());
                formData.append('product_id', $('#product_id').val());
                formData.append('stock', $('#stock').val());

                let ajax = ajaxPost(`{{ route('incoming-product.post') }}`, formData);
                ajax.done(function(response) {
                    $("body").LoadingOverlay("hide", true);
                    if (response.meta.status == 'error') {
                        toastr.error(response.meta.message);
                        console.log(response.data);
                        return false;
                    } else {
                        console.log(response);
                        toastr.success(response.meta.message);
                        data_table.ajax.reload(null, false);
                        $('#createIncomingProduct').modal('hide');
                        $('#form').trigger('reset');
                        $('#createIncomingProduct .select2').val("");
                        $('#createIncomingProduct .select2').select2({
                            theme: 'bootstrap4'
                        }).trigger('change');
                    }
                });
                ajax.error(function(jqXhr, textStatus, errorThrown) {
                    $("#body").LoadingOverlay("hide", true);
                    toastr.error(errorThrown);
                });
            });

            $('#edit-form').on('submit', function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                $("body").LoadingOverlay("show");
                let formData = new FormData();
                formData.append('_method', 'put');
                formData.append('edit_created_at', $('#edit_created_at').val());
                formData.append('edit_product_id', $('#edit_product_id').val());
                formData.append('edit_stock', $('#edit_stock').val());

                let ajax = ajaxPost(url, formData);
                ajax.done(function(response) {
                    $("body").LoadingOverlay("hide", true);
                    if (response.meta.status == 'error') {
                        toastr.error(response.meta.message);
                        console.log(response.data);
                    } else {
                        console.log(response);
                        toastr.success(response.meta.message);
                        data_table.ajax.reload(null, false);
                        $('#editIncomingProduct').modal('hide');
                        $('#form').trigger('reset');
                        $('#editIncomingProduct .select2').val("");
                        $('#editIncomingProduct .select2').select2({
                            theme: 'bootstrap4'
                        }).trigger('change');
                    }
                });
                ajax.error(function(jqXhr, textStatus, errorThrown) {
                    $("#body").LoadingOverlay("hide", true);
                    toastr.error(errorThrown);
                });
            });

            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Barang',
            });

            $('#example1 tbody').on('click', '.btn-delete', function() {
                var data = data_table.row($(this).closest("tr")).data();
                custom_confirm(data);
            });

            $('#example1 tbody').on('click', '.btn-edit', function() {
                var data = data_table.row($(this).closest("tr")).data();
                $('#edit-form').attr('action',
                    `{{ url('/incoming-product') }}/${data.id}/edit`);

                $('#editIncomingProduct #edit_created_at').val(dateFormat(data.created_at));
                $('#editIncomingProduct .select2').val(data.product_id);
                $('#editIncomingProduct .select2').select2({
                    theme: 'bootstrap4'
                }).trigger('change');
                $('#edit_stock').val(data.stock_quantity);
            });
        });

    </script>
@endsection
