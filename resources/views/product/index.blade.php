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
                     <h3 class="card-title">Data Master Barang</h3>
                 </div>
                 <!-- /.card-header -->
                 <div class="card-body">
                     @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
                         <div class="row mb-3">
                             <div class="col-12 text-right">
                                 <button class="btn btn-primary btn-sm rounded-0" data-toggle="modal"
                                     data-target="#createProduct">
                                     <i class="fas fa-plus mr-1"></i>
                                     TAMBAH</button>
                             </div>
                             <!-- Modal -->
                             <div class="modal fade" id="createProduct" tabindex="-1" aria-labelledby="createProductLabel"
                                 aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="createProductLabel">Tambah Barang</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                             </button>
                                         </div>
                                         <div class="modal-body">
                                             <form id="form" action="{{ route('product.post') }}" method="POST">
                                                 @csrf
                                                 <div class="row">
                                                     <div class="col-md-12 form-group">
                                                         <label for="name">Nama Barang</label>
                                                         <input type="text" id="name" name="name"
                                                             value="{{ old('name') }}" class="form-control"
                                                             autocomplete="off" style="width: 100%;" required>
                                                         @error('name')
                                                             <span>
                                                                 <small class="text-danger">{{ $message }}</small>
                                                             </span>
                                                         @enderror
                                                     </div>
                                                     <div class="col-md-12 form-group">
                                                         <label for="unit">Satuan</label>
                                                         <select id="unit" name="unit" class="form-control select2"
                                                             style="width: 100%;" required>
                                                             <option value="">Pilih Barang</option>
                                                             <option value="Buah">Buah</option>
                                                             <option value="Buku">Buku</option>
                                                             <option value="Botol">Botol</option>
                                                             <option value="Dos">Dos</option>
                                                             <option value="Lembar">Lembar</option>
                                                             <option value="Lusin">Lusin</option>
                                                             <option value="Pak">Pak</option>
                                                             <option value="Rim">Rim</option>
                                                         </select>
                                                         <!-- /.form-group -->
                                                         @error('unit')
                                                             <span>
                                                                 <small class="text-danger">{{ $message }}</small>
                                                             </span>
                                                         @enderror
                                                     </div>

                                                     <div class="col-md-12 form-group">
                                                         <label for="unit_price">Harga Satuan (Rp.)</label>
                                                         <input type="text" id="unit_price" name="unit_price"
                                                             value="{{ old('unit_price') }}" class="form-control"
                                                             autocomplete="off" style="width: 100%;"
                                                             data-inputmask-alias="currency"
                                                             data-inputmask-inputformat="000.000.000" data-mask required>
                                                         @error('unit_price')
                                                             <span>
                                                                 <small class="text-danger">{{ $message }}</small>
                                                             </span>
                                                         @enderror
                                                     </div>
                                                     <div class="col-12">
                                                         <button type="submit"
                                                             class="btn btn-success rounded-0 btn-block">SIMPAN</button>
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
                     @endif
                     <table id="example1" class="table table-bordered table-striped table-sm">
                         <thead>
                             <tr>
                                 <th>No</th>
                                 <th>Nama Barang</th>
                                 <th>Stok</th>
                                 <th>Satuan</th>
                                 <th>Harga Satuan</th>
                                 {{-- @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2) --}}
                                 <th>
                                     Aksi
                                 </th>
                                 {{-- @endif --}}
                             </tr>
                         </thead>
                         {{-- Data generate by dataTable --}}
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

     @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
         <!-- Modal -->
         <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="editProductLabel">Ubah Barang</h5>
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
                                     <label for="edit_name">Nama Barang</label>
                                     <input type="text" id="edit_name" name="edit_name" value="{{ old('edit_name') }}"
                                         class="form-control" autocomplete="off" style="width: 100%;">
                                     @error('edit_name')
                                         <span>
                                             <small class="text-danger">{{ $message }}</small>
                                         </span>
                                     @enderror
                                 </div>
                                 <div class="col-md-12 form-group">
                                     <label for="edit_unit">Satuan</label>
                                     <select id="edit_unit" name="edit_unit" class="form-control select2"
                                         style="width: 100%;">
                                         <option value="Buah">Buah</option>
                                         <option value="Buku">Buku</option>
                                         <option value="Botol">Botol</option>
                                         <option value="Dos">Dos</option>
                                         <option value="Lembar">Lembar</option>
                                         <option value="Lusin">Lusin</option>
                                         <option value="Pak">Pak</option>
                                         <option value="Rim">Rim</option>
                                     </select>
                                     <!-- /.form-group -->
                                     @error('edit_unit')
                                         <span>
                                             <small class="text-danger">{{ $message }}</small>
                                         </span>
                                     @enderror
                                 </div>

                                 <div class="col-md-12 form-group">
                                     <label for="edit_unit_price">Harga Satuan (Rp.)</label>
                                     <input type="text" id="edit_unit_price" name="edit_unit_price"
                                         value="{{ old('edit_unit_price') }}" class="form-control" autocomplete="off"
                                         style="width: 100%;" data-inputmask-alias="currency"
                                         data-inputmask-inputformat="000.000.000" data-mask>
                                     @error('edit_unit_price')
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
     <!-- Jquery Input Mask -->
     <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
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

     <script type="text/javascript">
         let data_table;

         //  Confirmation alert to delete product
         function custom_confirm(data) {
             Swal.fire({
                 title: `Anda yakin ingin menghapus ${data.name} ?`,
                 text: 'Barang yang dihapus tidak dapat dikembalikan.',
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

                     let ajax = ajaxPost(`{{ url('/product') }}/${data.id}/delete`, form);
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

         function initDataTable() {
             let data_table = $("#example1").DataTable({
                 "responsive": true,
                 "autoWidth": false,
                 "ajax": `{{ route('product.all') }}`,
                 "columns": [{
                     data: null,
                 }, {
                     "data": 'name'
                 }, {
                     "data": 'stock'
                 }, {
                     "data": 'unit'
                 }, {
                     "data": 'unit_price'
                 }, {
                     "data": null
                 }],
                 "columnDefs": [{
                     'targets': 5,
                     'render': function(data, type, full_row, meta) {
                         return `<button type="button" class="btn btn-warning btn-sm btn-edit"  data-toggle="modal" data-target="#editProduct">` +
                             `<i class="nav-icon fas fa-edit"></i>` +
                             `</button>` +
                             `<button class="btn btn-sm btn-danger rounded-1 btn-delete ml-2">` +
                             `<i class="nav-icon fas fa-trash"></i>` +
                             `</button>`;
                     }
                 }],
                 "fnCreatedRow": function(row, data, index) {
                     if (data.stock > 5 && data.stock <= 10) {
                         $(row).addClass('my-bg-warning');

                         //  $('td', row).eq(2).html(`<span class"badge badge-danger">${data.stock}</span>`);
                         //  $('td', row).eq(2).addClass('bg-warning');
                     } else if (data.stock < 5) {
                         $(row).addClass('my-bg-danger');
                         //  $('td', row).eq(2).html('<span class="badge badge-danger">' + data.stock + '</span>');
                     } else {
                         $('td', row).eq(2).html(data.stock);
                     }
                     $('td', row).eq(0).html(index + 1);
                     $('td', row).eq(4).html(new Intl.NumberFormat('id-ID', {
                         // maximumSignificantDigits: 0,
                         style: 'currency',
                         currency: 'IDR'
                     }).format(data.unit_price));
                 }

             });
             let current_userID = `{{ Auth::user()->division_id }}`;
             if (current_userID != 1 && current_userID != 2) {
                 data_table.column(5).visible(false);
             }

             //  }
             return data_table;
         }

         $(document).ready(function() {

             data_table = initDataTable();

             $('#createProduct .select2').select2({
                 theme: 'bootstrap4',
                 placeholder: 'Pilih Satuan',
             });

             $('#editProduct .select2').select2({
                 theme: 'bootstrap4'
             });

             $('#form').on('submit', function(e) {
                 e.preventDefault();
                 $("body").LoadingOverlay("show");
                 let formData = new FormData();
                 formData.append('name', $('#name').val());
                 formData.append('unit', $('#unit').val());
                 formData.append('unit_price', $('#unit_price').inputmask('unmaskedvalue'));

                 let ajax = ajaxPost(`{{ route('product.post') }}`, formData);
                 ajax.done(function(response) {
                     $("body").LoadingOverlay("hide", true);
                     if (response.meta.status == 'error') {
                         toastr.error(response.meta.message);
                         console.log(response.data);
                         return false;
                     } else {
                         toastr.success(response.meta.message);
                         data_table.ajax.reload(null, false);
                         $('#createProduct').modal('hide');
                         $('#form').trigger('reset');
                         $('#createProduct .select2').val("");
                         $('#createProduct .select2').select2({
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
                 formData.append('edit_name', $('#edit_name').val());
                 formData.append('edit_name', $('#edit_name').val());
                 formData.append('edit_unit', $('#edit_unit').val());
                 formData.append('edit_unit_price', $('#edit_unit_price').inputmask('unmaskedvalue'));

                 let ajax = ajaxPost(url, formData);
                 ajax.done(function(response) {
                     $("body").LoadingOverlay("hide", true);

                     if (response.meta.status == 'error') {
                         toastr.error(response.meta.message);
                         console.log(response.data);
                         return false;
                     } else {
                         data_table.ajax.reload(null, false);
                         toastr.success(response.meta.message);
                         $('#editProduct').modal('hide');
                         $('#edit-form').trigger('reset');
                     }
                 });
                 ajax.error(function(jqXhr, textStatus, errorThrown) {
                     $("#body").LoadingOverlay("hide", true);
                     toastr.error(errorThrown);
                 });
             });

             $('#unit_price').inputmask({
                 radixPoint: ".",
                 groupSeparator: ",",
                 digits: 0,
                 autoGroup: true,
                 prefix: 'Rp. ',
                 removeMaskOnSubmit: true
             });
             $('#edit_unit_price').inputmask({
                 radixPoint: ".",
                 groupSeparator: ",",
                 digits: 0,
                 autoGroup: true,
                 prefix: 'Rp. ',
                 removeMaskOnSubmit: true
             });

             $('#example1 tbody').on('click', '.btn-delete', function() {
                 var data = data_table.row($(this).closest("tr")).data();
                 custom_confirm(data);
             });

             $('#example1 tbody').on('click', '.btn-edit', function() {
                 var data = data_table.row($(this).closest("tr")).data();
                 $('#edit-form').attr('action', `{{ url('/product') }}/${data.id}/edit`);

                 $('#editProduct #edit_name').val(data.name);
                 $('#editProduct .select2').val(data.unit);
                 $('#editProduct .select2').select2({
                     theme: 'bootstrap4'
                 }).trigger('change');
                 $('#edit_unit_price').val(data.unit_price);

             });
         });

     </script>
 @endsection
