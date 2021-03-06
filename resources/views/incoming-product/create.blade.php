@extends('templates.template')

@section('title', 'ADMINISTRATOR')

@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page', 'Tambah Transaksi Barang Masuk')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Form Transaksi Barang Masuk</h3>

                    {{-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="form" action="{{ route('incoming-product.post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group row">
                                <label for="created_at" class="col-sm-2">Tanggal <sup class="text-danger">*</sup></label>
                                <div class="col-sm-3">
                                    <input type="date" id="created_at" name="created_at"
                                        value="{{ old('created_at') ?? date('Y-m-d') }}" class="form-control" required>
                                    @error('created_at')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 form-group row">
                                <label for="division" class="col-sm-2">Barang <sup class="text-danger">*</sup></label>
                                <div class="col-sm-5">

                                    <select id="product_id" name="product_id" class="form-control select2" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} |
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
                            </div>

                            <div class="col-md-12 form-group row">
                                <label for="stock" class="col-sm-2">Kuantitas <sup class="text-danger">*</sup> </label>
                                <div class="col-sm-2">

                                    <input type="number" id="stock" name="stock" value="{{ old('stock') }}"
                                        class="form-control" autocomplete="off" required>
                                    @error('stock')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <p>
                                <sup class="text-danger">*</sup> <small>Data wajib diisi.</small>
                            </p>
                            <div class="col-md-12 text-left">
                                <button type="submit" class="btn btn-success rounded-0 px-5">SIMPAN</button>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </form>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
@section('script')
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Jquery Input Mask -->
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Barang',
            });

            $('#unit_price').inputmask({
                radixPoint: ".",
                groupSeparator: ",",
                digits: 0,
                autoGroup: true,
                prefix: 'Rp. ',
                removeMaskOnSubmit: true
            });
        });

    </script>
@endsection
