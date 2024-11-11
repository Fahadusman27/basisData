@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pengadaan</h5>
        <a href="{{ route('pengadaan.create') }}" class="btn btn-primary">Buat Pengadaan</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Vendor</th>
                    <th>Subtotal</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengadaan as $item)
                <tr>
                    <td>{{ $item->id_pengadaan }}</td>
                    <td>{{ $item->TIMESTAMP }}</td>
                    <td>{{ $item->vendor->nama_vendor }}</td>
                    <td>Rp {{ number_format($item->subtotal_nilai, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                    <td>{{ $item->STATUS }}</td>
                    <td>
                        <a href="{{ route('pengadaan.show', $item->id_pengadaan) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pengadaan.edit', $item->id_pengadaan) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
