@extends('layouts.template')
 @section('content')
 <div class="card">
     <div class="card-header">
         <h3 class="card-title">Daftar Level</h3>
         <div class="card-tools">
            <button onclick="modalAction('{{ route('level.import') }}')" class="btn btn-sm btn-info">Import Level</button>
            <a href="{{ route('level.export_excel') }}" class="btn btn-sm btn-primary">Export Level</a>
            <a href="{{ route('level.export_pdf') }}" class="btn btn-sm btn-warning"><i class="fa fa-file-pdf"></i> Export Level PDF</a>
            <button onclick="modalAction('{{ route('level.create_ajax')}}')" class="btn btn-sm btn-success">Tambah Ajax</button>
         </div>
     </div>
     <div class="card-body">
         @if(session('success'))
             <div class="alert alert-success alert-dismissible">
                 <h5><i class="icon fas fa-check"></i> Success!</h5>
                 {{ session('success') }}
             </div>
         @endif
         
         @if(session('error'))
             <div class="alert alert-danger alert-dismissible">
                 <h5><i class="icon fas fa-ban"></i> Error!</h5>
                 {{ session('error') }}
             </div>
         @endif
         
         <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>Kode</th>
                     <th>Nama</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
         </table>
     </div>
 </div>
 <div id="myModal" class="modal fade animate shake" tabindex="-1" databackdrop="static"
          data-keyboard="false" data-width="75%">
      </div>
 @endsection
 @push('css')
 @endpush
 @push('js')
 <script>
    function modalAction(url = ''){ 
             $('#myModal').load(url,function(){ 
                 $('#myModal').modal('show'); 
             }); 
         }
     var tableLevel;
     $(document).ready(function() {
         tableLevel = $('#table_level').DataTable({
            processing: true,
             serverSide: true,
             ajax: {
                 "url": "{{ url('level/list') }}",
                 "dataType": "json",
                 "type": "POST"
             },
             columns: [
                 {
                     data: "DT_RowIndex",
                     className: "text-center",
                     orderable: false,
                     searchable: false
                 },{
                     data: "kode_level",
                     className: "",
                     orderable: true,
                     searchable: true
                 },{
                     data: "kode_nama",
                     className: "",
                     orderable: true,
                     searchable: true
                 },{
                     data: "aksi",
                     className: "text-center",
                     width: "15%",
                     orderable: false,
                     searchable: false
                 }
             ]
         });
     });
 </script>
 @endpush