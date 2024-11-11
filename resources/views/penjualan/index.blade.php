@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Penjualan</h5>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">Buat Penjualan</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Subtotal</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>User</th>
                    <th>Margin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan as $item)
                <tr>
                    <td>{{ $item->idpenjualan }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>Rp {{ number_format($item->subtotal_nilai, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                    <td>{{ $item->user->username }}</td>
                    <td>{{ $item->margin_penjualan->persen }}%</td>
                    <td>
                        <a href="{{ route('penjualan.show', $item->idpenjualan) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
