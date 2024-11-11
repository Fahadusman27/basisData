@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Kartu Stok</h5>
    </div>
    <div class="card-body">
        <form class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="barang" class="form-select">
                        <option value="">Pilih Barang</option>
                        @foreach($barang as $item)
                        <option value="{{ $item->id_barang }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" placeholder="Tanggal Mulai">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control" placeholder="Tanggal Selesai">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Stok</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kartuStok as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->jenis_transaksi }}</td>
                    <td>{{ $item->masuk }}</td>
                    <td>{{ $item->keluar }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
