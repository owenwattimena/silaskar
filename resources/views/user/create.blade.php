@extends('templates.template')

@section('title', 'ADMINISTRATOR')

@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page', 'Tambah User')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Data User</h3>

                    {{-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="form" action="{{ route('user.post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group row">
                                <label for="name" class="col-sm-2">Nama <sup class="text-danger">*</sup> </label>
                                <div class="col-sm-6">

                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        class="form-control" autocomplete="off" required>
                                    @error('name')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 form-group row">
                                <label for="division" class="col-sm-2">Bagian <sup class="text-danger">*</sup></label>
                                <div class="col-sm-3">

                                    <select id="division" name="division" class="form-control select2" required>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- /.form-group -->
                                    @error('division')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 form-group row">
                                <label for="username" class="col-sm-2">Username <sup class="text-danger">*</sup></label>
                                <div class="col-sm-3">
                                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                                        class="form-control" autocomplete="off" data-inputmask-regex="[a-zA-Z0-9]*"
                                        required>
                                    @error('username')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 form-group row">
                                <label for="password" class="col-sm-2">Password <sup class="text-danger">*</sup></label>
                                <div class="col-sm-3">

                                    <input type="password" id="password" name="password" value="" class="form-control"
                                        autocomplete="off" required>
                                    @error('password')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 form-group row">
                                <label for="password-confirm" class="col-sm-2">Konfirmasi Password<sup
                                        class="text-danger">*</sup></label>
                                <div class="col-sm-3">

                                    <input type="password" id="password-confirm" name="password_confirmation" value=""
                                        class="form-control" autocomplete="off" required>
                                    @error('password_confirmation')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 form-group row">
                                <label for="phone_number" class="col-sm-2">Nomor Telepon</label>
                                <div class="col-sm-3">
                                    <input type="tel" id="phone_number" name="phone_number"
                                        value="{{ old('phone_number') }}" class="form-control" autocomplete="off">
                                    @error('phone_number')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <p>
                                <sup class="text-danger">*</sup> <small>Data wajib diisi.</small>
                            </p>
                            <div class="col-md-12">
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
                theme: 'bootstrap4'
            });

            $("#username").inputmask();
        });

    </script>
@endsection
