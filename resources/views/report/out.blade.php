@extends('templates.template')

@section('style')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
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
@section('page', 'Laporan Permintaan Barang')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Cari laporan berdasarkan rentang waktu</div>
                <div class="card-header">
                    <form action="{{ route('report-out.pdf') }}" method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-md-4">
                                <label>Rentang Waktu</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="date_range" class="form-control float-right" id="date_range">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status">Status</label>

                                <div class="input-group">
                                    <select name="status" id="status" class="form-control">
                                        <option selected value="Proses">Proses</option>
                                        <option value="Disetujui">Disetujui</option>
                                        <option value="Ditolak">Ditolak</option>
                                        <option value="semua">Semua</option>
                                    </select>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group col-md-2">
                                <label></label>
                                <div class="input-group mt-2">
                                    <button type="button" class="btn btn-success form-control btn-search">CARI</button>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group col-md-2">
                                <label></label>
                                <div class="input-group mt-2">
                                    <button type="submit" class="btn btn-danger form-control ">
                                        <i class="fa fa-file-pdf"></i>
                                        PDF</button>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </form>
                    <!-- /.form group -->
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header search-description">
                    Belum ada pencarian
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-striped">
                            <thead>
                                <th>TANGGAL</th>
                                <th>NAMA BARANG</th>
                                <th>KUANTITAS</th>
                                <th>HARGA SATUAN (Rp)</th>
                                <th>JUMLAH</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
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
        $(function() {
            var options = {
                // weekday: 'short',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            var startDate = dateFormat(new Date());
            var endDate = dateFormat(new Date());
            $('#date_range').daterangepicker({
                opens: 'right',
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                startDate = picker.startDate.format('YYYY-MM-DD');
                endDate = picker.endDate.format('YYYY-MM-DD');
            });


            let data_table = $("#table").DataTable({
                "responsive": false,
                "searching": false,

                // "ajax": `{{ url('/report/search?start=') }}2021-03-06&end=2021-03-06&status=semua`,
                "columns": [{
                        data: null
                    },
                    {
                        data: 'product.name'
                    },
                    {
                        data: null
                    },
                    {
                        data: null
                    },
                    {
                        data: null
                    },
                ],
                "columnDefs": [{
                        'targets': 3,
                        'render': function(data, type, full_row, meta) {
                            return new Intl.NumberFormat('id-ID', {
                                maximumSignificantDigits: 2,
                                style: 'currency',
                                currency: 'IDR'
                            }).format(data.total / data.stock_quantity);
                        }
                    },
                    {
                        'targets': 4,
                        'render': function(data, type, full_row, meta) {
                            return new Intl.NumberFormat('id-ID', {
                                maximumSignificantDigits: 2,
                                style: 'currency',
                                currency: 'IDR'
                            }).format(data.total);

                        }
                    }
                ],
                "fnCreatedRow": function(row, data, index) {

                    var date = new Date(data.updated_at);
                    $('td', row).eq(0).html(date.toLocaleDateString("id-ID", options));
                    $('td', row).eq(2).html(data.stock_quantity + ' ' + data.product.unit);
                }
            })

            $(document).ready(function() {
                $('.btn-search').on('click', function() {
                    var status = $('#status').val();
                    console.log(startDate);
                    console.log(endDate);
                    console.log(status);
                    // data_table.ajax.url(
                    //     `{{ url('/report/search?start=') }}2021-03-06&end=2021-03-06&status=semua`
                    //     ).load();
                    // data_table.ajax.reload();
                    $("body").LoadingOverlay("show");

                    if (data_table.ajax.url("{{ url('/report-out/search?start=') }}" +
                            startDate +
                            "&end=" + endDate + "&status=" + status).load()) {
                        $("body").LoadingOverlay("hide", true);
                    } else {
                        $("body").LoadingOverlay("hide", true);
                    }
                    var awal = new Date(startDate).toLocaleDateString("id-ID", options);
                    var akhir = new Date(endDate).toLocaleDateString("id-ID", options);
                    $('.search-description').html(
                        `Hasil pencarian dari tanggal ${awal} s/d ${akhir}`);
                    // data_table.ajax.reload();
                });
            });
        });

    </script>
@endsection
