@extends('layouts.app')

@section('content')
<div class="row">
    {{-- Summary Cards --}}
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Barang</h6>
                        <h2 class="mb-0">{{ $totalBarang }}</h2>
                    </div>
                    <i class="fas fa-box fa-2x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('barang.index') }}" class="text-white text-decoration-none">Lihat Detail</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Pengadaan Bulan Ini</h6>
                        <h2 class="mb-0">{{ $pengadaanBulanIni }}</h2>
                    </div>
                    <i class="fas fa-truck-loading fa-2x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('pengadaan.index') }}" class="text-white text-decoration-none">Lihat Detail</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Penjualan Bulan Ini</h6>
                        <h2 class="mb-0">{{ $penjualanBulanIni }}</h2>
                    </div>
                    <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('penjualan.index') }}" class="text-white text-decoration-none">Lihat Detail</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Pendapatan</h6>
                        <h2 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-white">Bulan {{ date('F Y') }}</span>
                <i class="fas fa-calendar"></i>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pengadaan Terakhir</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Vendor</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPengadaan as $pengadaan)
                        <tr>
                            <td>{{ $pengadaan->id_pengadaan }}</td>
                            <td>{{ $pengadaan->TIMESTAMP }}</td>
                            <td>{{ $pengadaan->vendor ? $pengadaan->vendor->nama_vendor : 'Vendor tidak tersedia' }}</td>
                            <td>Rp {{ number_format($pengadaan->total_nilai, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Penjualan Terakhir</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPenjualan as $penjualan)
                        <tr>
                            <td>{{ $penjualan->idpenjualan }}</td>
                            <td>{{ $penjualan->created_at }}</td>
                            <td>{{ $penjualan->user ? $penjualan->user->username : 'User tidak tersedia' }}</td>
                            <td>Rp {{ number_format($penjualan->total_nilai, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Stock Alert --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Peringatan Stok</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok Saat Ini</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockAlert as $stock)
                        <tr>
                            <td>{{ $stock->id_barang }}</td>
                            <td>{{ $stock->nama }}</td>
                            <td>{{ $stock->stok_tersedia }}</td>
                            <td>
                                @if($stock->stok_tersedia <= $stock->minimum_stok)
                                    <span class="badge bg-danger">Stok Minimum</span>
                                @elseif($stock->stok_tersedia <= $stock->minimum_stok * 1.5)
                                    <span class="badge bg-warning">Stok Menipis</span>
                                @else
                                    <span class="badge bg-success">Stok Aman</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
