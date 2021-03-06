@extends('templates.template')

@section('title', 'ADMINISTRATOR')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page', 'Barang')

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
                    <h3 class="card-title">Data Master Barang Masuk</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm rounded-0">
                                <i class="fas fa-plus"></i>
                                TAMBAH</a>
                        </div>
                    </div>
                    <table id="example1" class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama </th>
                                <th>Username</th>
                                <th>Bagian</th>
                                <th>Nomor Telepon</th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->division->name }}</td>
                                    <td>{{ $user->phone_number ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm rounded-0"><i class="fas fa-user-cog"></i> UBAH
                                        </a>

                                        <form action="{{ route('user.access', $user->id) }}" method="POST"
                                            class="form d-inline">
                                            @csrf
                                            @method('put')
                                            <button type="submit"
                                                class="btn btn-sm btn-{{ $user->status == 'active' ? 'dark' : 'success' }} rounded-0"
                                                data-toggle="tooltip" data-placement="top"
                                                title="{{ $user->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-power-off"></i>
                                                {{ $user->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                        </form>

                                        <form action="{{ route('user.delete', $user->id) }}" method="POST"
                                            class="form d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="custom_confirm(event, '{{ $user->name }}')"
                                                class="btn btn-sm btn-danger rounded-0"> <i class="fas fa-trash"></i>
                                                HAPUS</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Harga Satuan</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
@section('script')
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Jquery Input Mask -->
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });

        function custom_confirm(event, name) {
            event.preventDefault();
            console.log(event.target);
            Swal.fire({
                title: `Anda yakin ingin menghapus ${name} ?`,
                text: 'User yang dihapus tidak dapat dikembalikan.',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: `Ya, Hapus`,
                cancelButtonText: `Batal`,
                confirmButtonColor: `#c92434`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value) {
                    $(event.target).closest('form').submit();
                    // Swal.fire('Saved!', '', 'success')
                }
            })
        }

    </script>
@endsection
