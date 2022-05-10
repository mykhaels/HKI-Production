@extends('adminlte::page')
@section('title', 'Mutasi Barang')

@section('content_header')
    <h1>Mutasi Barang</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/custom.css">
@stop


@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<table class="table table-bordered table-hover dataTable dtr-inline" role="grid" id="transfer-in-table">
    <thead>
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Kode Mutasi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Tanggal Mutasi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Tipe Produk Asal</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Tipe Produk Tujuan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mutations as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->from_product_type }}</td>
                <td>{{ date('d-M-Y', strtotime($item->to_product_type)) }}</td>
                <td><a class="btn btn-success" href="mutation/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $mutations->links() }}
    </div>
 </div>
@stop

@section('footer')
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/mutation/create">Buat Baru</a>
    </div>
@stop



