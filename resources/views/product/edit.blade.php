@extends('templates.template')

@section('title', 'ADMINISTRATOR')

@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page', 'Ubah Barang')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Form Ubah Data Barang</h3>

                    {{-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="form" action="{{ route('product.put', $product->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Nama Barang</label>
                                <input type="text" id="name" name="name" value="{{ old('name') ?? $product->name }}"
                                    class="form-control" autocomplete="off" style="width: 100%;">
                                @error('name')
                                    <span>
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="unit">Satuan</label>
                                <select id="unit" name="unit" class="form-control select2" style="width: 100%;">
                                    <option {{ $product->unit == 'Buah' ? 'selected' : '' }} value="Buah">Buah</option>
                                    <option {{ $product->unit == 'Buku' ? 'selected' : '' }} value="Buku">Buku</option>
                                    <option {{ $product->unit == 'Botol' ? 'selected' : '' }} value="Botol">Botol</option>
                                    <option {{ $product->unit == 'Dos' ? 'selected' : '' }} value="Dos">Dos</option>
                                    <option {{ $product->unit == 'Lembar' ? 'selected' : '' }} value="Lembar">Lembar
                                    </option>
                                    <option {{ $product->unit == 'Lusin' ? 'selected' : '' }} value="Lusin">Lusin
                                    </option>
                                    <option {{ $product->unit == 'Pak' ? 'selected' : '' }} value="Pak">Pak</option>
                                    <option {{ $product->unit == 'Rim' ? 'selected' : '' }} value="Rim">Rim</option>
                                </select>
                                <!-- /.form-group -->
                                @error('unit')
                                    <span>
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="unit_price">Harga Satuan (Rp.)</label>
                                <input type="text" id="unit_price" name="unit_price"
                                    value="{{ old('unit_price') ?? $product->unit_price }}" class="form-control"
                                    autocomplete="off" style="width: 100%;" data-inputmask-alias="currency"
                                    data-inputmask-inputformat="000.000.000" data-mask>
                                @error('unit_price')
                                    <span>
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success rounded-0 btn-block">SIMPAN</button>
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
                theme: 'bootstrap4'
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
