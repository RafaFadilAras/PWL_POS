@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('detail.create') }}">Tambah Detail</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="penjualan_id" name="penjualan_id">
                                <option value="">- Semua Penjualan -</option>
                                @foreach($penjualan as $item)
                                    <option value="{{ $item->penjualan_id }}">{{ $item->penjualan_id }} - {{ $item->tanggal }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">ID Penjualan</small>
                        </div>
                        <div class="col-3">
                            <select class="form-control" id="barang_id" name="barang_id">
                                <option value="">- Semua Barang -</option>
                                @foreach($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Nama Barang</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="tabel_detail">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Penjualan</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        var dataDetail;
        $(document).ready(function () {
            dataDetail = $('#tabel_detail').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ route('detail.list') }}",
                    "datatype": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.penjualan_id = $('#penjualan_id').val();
                        d.barang_id = $('#barang_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "penjualan.penjualan_id",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "barang.barang_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "harga",
                        className: "text-right",
                        orderable: true,
                        searchable: false,
                        render: function (data, type, row) {
                            return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: "jumlah",
                        className: "text-center",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "total",
                        className: "text-right",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#penjualan_id, #barang_id').on('change', function () {
                dataDetail.ajax.reload();
            });
        });
    </script>
@endpush