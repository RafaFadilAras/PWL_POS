@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($detail)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <div class="row">
                    <div class="col-md-4">
                        @if($detail->barang->image)
                            <img src="{{ $detail->barang->image }}" alt="{{ $detail->barang->barang_nama }}" class="img-fluid img-thumbnail">
                        @else
                            <div class="text-center p-4 bg-light">
                                <i class="fas fa-image fa-4x text-muted"></i>
                                <p class="mt-2">Gambar tidak tersedia</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th width="200">ID Detail</th>
                                <td>{{ $detail->detail_id }}</td>
                            </tr>
                            <tr>
                                <th>ID Penjualan</th>
                                <td>{{ $detail->penjualan_id }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Penjualan</th>
                                <td>{{ $detail->penjualan->penjualan_tanggal }}</td>
                            </tr>
                            <tr>
                                <th>Barang</th>
                                <td>{{ $detail->barang->barang_nama }}</td>
                            </tr>
                            <tr>
                                <th>Kode Barang</th>
                                <td>{{ $detail->barang->barang_kode }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $detail->barang->kategori->kategori_nama ?? 'Tidak ada kategori' }}</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>Rp {{ number_format($detail->harga, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>{{ $detail->jumlah }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>Rp {{ number_format($detail->harga * $detail->jumlah, 2, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endempty
            <a href="{{ url('detail') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
<style>
    .img-thumbnail {
        max-height: 300px;
        object-fit: contain;
    }
</style>
@endpush

@push('js')
@endpush