@extends('templates.template')

@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page', 'Profil')

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
        <div class="col-md-8">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Ubah Profil</h3>

                    {{-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <form id="form" action="{{ route('profile.put') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-12 form-group row">
                                <label for="name" class="col-md-4">Nama <sup class="text-danger">*</sup> </label>
                                <div class="col-md-8">

                                    <input type="text" id="name" name="name" value="{{ \Auth::user()->name }}"
                                        class="form-control" autocomplete="off" required>
                                    @error('name')
                                        <span>
                                            <small class="text-danger">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 form-group row">
                                <label for="username" class="col-md-4">Username <sup class="text-danger">*</sup></label>
                                <div class="col-md-5">
                                    <input type="text" id="username" name="username" value="{{ \Auth::user()->username }}"
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
                                <label for="phone_number" class="col-md-4">Nomor Telepon</label>
                                <div class="col-md-5">
                                    <input type="tel" id="phone_number" name="phone_number"
                                        value="{{ \Auth::user()->phone_number }}" class="form-control" autocomplete="off">
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
        <div class="col-md-4">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Ubah Password </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="form" action="{{ route('profile.change-password') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="col-md-12 form-group">
                            <label for="password">Password <sup class="text-danger">*</sup></label>
                            <div>

                                {{-- <small>Gunakan password anda sebagai administrator</small> --}}
                                <input type="password" id="password" name="password" value="" class="form-control"
                                    autocomplete="off" required>
                                @error('password')
                                    <span>
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="password_baru">Password Baru <sup class="text-danger">*</sup></label>
                            <input type="password" id="password_baru" name="password_baru" value="" class="form-control"
                                autocomplete="off" required>
                            @error('password_baru')
                                <span>
                                    <small class="text-danger">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="password-confirm">Konfirmasi Password Baru<sup class="text-danger">*</sup></label>

                            <input type="password" id="password-confirm" name="password_baru_confirmation" value=""
                                class="form-control" autocomplete="off" required>
                            @error('password_baru_confirmation')
                                <span>
                                    <small class="text-danger">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <p>
                            <sup class="text-danger">*</sup> <small>Data wajib diisi.</small>
                        </p>
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark rounded-0 btn-block">SIMPAN</button>
                        </div>
                        <!-- /.col -->
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
