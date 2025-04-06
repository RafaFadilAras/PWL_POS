<!DOCTYPE html>
 <html lang="en">
 
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Registrasi Pengguna</title>
 
     <!-- Google Font: Source Sans Pro -->
     <link rel="stylesheet"
         href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
     <!-- Font Awesome -->
     <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
     <!-- icheck bootstrap -->
     <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
     <!-- SweetAlert2 -->
     <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
     <!-- Theme style -->
     <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
     <style>
         .login-box {
             width: 600px;
             max-width: 90%;
         }
     </style>
 
 </head>
 
 <body class="hold-transition login-page">
     <div class="login-box">
         <div class="card card-outline card-primary">
             <div class="card-header text-center">
                 <a href="{{ url('/') }}" class="h1"><b>Admin</b>LTE</a>
             </div>
             <div class="card-body">
                 <p class="login-box-msg">Form Registrasi Pengguna Baru</p>
                 <form method="POST" action="{{ url('user/storeRegister') }}" class="form-horizontal" id="form-register">
                     @csrf
 
                     <!-- Level -->
                     <div class="form-group row">
                         <label class="col-3 col-form-label">Level</label>
                         <div class="col-9">
                             <select class="form-control" id="level_id" name="level_id" required>
                                 <option value="">- Pilih Level -</option>
                                 @foreach($level as $item)
                                     <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                 @endforeach
                             </select>
                             <small id="error-level_id" class="error-text text-danger"></small>
                         </div>
                     </div>
 
                     <!-- Username -->
                     <div class="form-group row">
                         <label class="col-3 col-form-label">Username</label>
                         <div class="col-9">
                             <input type="text" class="form-control" id="username" name="username"
                                 value="{{ old('username') }}" required placeholder="Masukkan username">
                                 <small id="error-username" class="error-text text-danger"></small>
                         </div>
                     </div>
 
                     <!-- Nama -->
                     <div class="form-group row">
                         <label class="col-3 col-form-label">Nama</label>
                         <div class="col-9">
                             <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                                 required placeholder="Masukkan nama lengkap">
                                 <small id="error-nama" class="error-text text-danger"></small>
                         </div>
                     </div>
 
                     <!-- Password -->
                     <div class="form-group row">
                         <label class="col-3 col-form-label">Password</label>
                         <div class="col-9">
                             <input type="password" class="form-control" id="password" name="password" required
                                 placeholder="Masukkan password">
                                 <small id="error-password" class="error-text text-danger"></small>
                         </div>
                     </div>
 
                     <!-- Tombol -->
                     <div class="form-group row">
                         <div class="offset-3 col-9">
                             <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                             <a class="btn btn-sm btn-default ml-1" href="{{ url('login') }}">Kembali</a>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>

     <!-- jQuery -->
     <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
     <!-- Bootstrap 4 -->
     <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <!-- jquery-validation -->
     <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
     <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
     <!-- SweetAlert2 -->
     <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
     <!-- AdminLTE App -->
     <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
 
 
     <script>
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
 
         $(document).ready(function () {
             $("#form-register").validate({
                 rules: {
                     username: {
                         required: true,
                         minlength: 3,
                         maxlength: 20
                     },
                     nama: {
                         required: true,
                         maxlength: 100
                     },
                     password: {
                         required: true,
                         minlength: 5,
                         maxlength: 20
                     },
                     level_id: {
                         required: true
                     }
                 },
                 submitHandler: function (form) {
                     $.ajax({
                         url: form.action,
                         type: form.method,
                         data: $(form).serialize(),
                         success: function (response) {
                             if (response.status) {
                                 Swal.fire({
                                     icon: 'success',
                                     title: 'Berhasil',
                                     text: response.message,
                                 }).then(function () {
                                     window.location = response.redirect;
                                 });
                             } else {
                                 $('.error-text').text('');
                                 if (response.msgField) {
                                     $.each(response.msgField, function (prefix, val) {
                                         $('#error-' + prefix).text(val[0]);
                                     });
                                 }
                                 Swal.fire({
                                     icon: 'error',
                                     title: 'Terjadi Kesalahan',
                                     text: response.message
                                 });
                             }
                         }
                     });
                     return false;
                 },
                 errorElement: 'span',
                 errorPlacement: function (error, element) {
                     error.addClass('invalid-feedback');
                     element.closest('.form-group').find('.col-9').append(error);
                 },
                 highlight: function (element) {
                     $(element).addClass('is-invalid');
                 },
                 unhighlight: function (element) {
                     $(element).removeClass('is-invalid');
                 }
             });
         });
     </script>
 
 </body>
 
 </html>