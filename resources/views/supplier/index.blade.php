@extends('layouts.template')
 
 @section('content')
 
     <div class="card">
         <div class="card-header">
             <h3 class="card-title">Data Supplier</h3>
             <div class="card-tools">
                <button onclick="modalAction('{{ route('supplier.import') }}')" class="btn btn-sm btn-info mt-1">Import Supplier</button>
                <a href="{{ route('supplier.export_excel') }}" class="btn btn-sm btn-primary mt-1">Export Supplier</a>
                <a href="{{ route('supplier.export_pdf') }}" class="btn btn-sm btn-warning mt-1"><i class="fa fa-file-pdf"></i> Export Supplier PDF</a>
                <button onclick="modalAction('{{url('supplier/create_ajax')}}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
             </div>
         </div>
 
         <div class="card-body">
 
             @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
             @endif
 
             @if (session('error'))
                 <div class="alert alert-danger">{{ session('error') }}</div>
             @endif
 
             <table class="table table-bordered table-striped table-hover table-sm" id="tabel_supplier">
                 <thead>
                     <tr>
                         <th>ID</th>
                         <th>Kode Supplier</th>
                         <th>Nama Supplier</th>
                         <th>Alamat Supplier</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>

     <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static"
     data-keyboard="false" data-width="75%" aria-hidden="true">
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
        var dataSupplier;
         $(document).ready(function () {
             dataSupplier = $('#tabel_supplier').DataTable({
                 serverSide: true,
                 ajax: {
                     "url": "{{ url('supplier/list') }}",
                     "datatype": "json",
                     "type": "POST"
                 },
                 columns: [
                     {
                         data: "DT_RowIndex",
                         className: "text-center",
                         orderable: false,
                         searchable: false
                     },
                     {
                         data: "supplier_kode",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "supplier_nama",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "supplier_alamat",
                         className: "",
                         orderable: false,
                         searchable: true
                     },
                     {
                         data: "aksi",
                         className: "",
                         orderable: false,
                         searchable: false
                     }
 
                 ]
             });
 
         });
     </script>
 @endpush