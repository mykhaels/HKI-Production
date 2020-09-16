@extends('adminlte::page')
@section('title', 'Pengeluaran Produksi')

@section('content_header')
    <h1>Pengeluaran Produksi</h1>
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
<table class="table table-bordered table-hover dataTable dtr-inline" role="grid" id="delivery-note-table">
    <thead>
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-note-table" rowspan="1" colspan="1">#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-note-table" rowspan="1" colspan="1">No. Pengeluaran</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-note-table" rowspan="1" colspan="1">Tanggal Pengeluaran</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-note-table" rowspan="1" colspan="1">Tipe Produk</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-note-table" rowspan="1" colspan="1">Tipe Pengeluaran</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-note-table" rowspan="1" colspan="1">No. Permintaan Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-note-table" rowspan="1" colspan="1">Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deliveryNotes as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                @if ($item->product_type==1)
                <td>Barang Jadi</td>
                @elseif ($item->product_type==2)
                <td>Bahan Baku</td>
                @else
                <td>Pendukung</td>
                @endif
                @if ($item->delivery_type==1)
                <td>Produksi</td>
                @else
                <td>Bahan Penolong</td>
                @endif
                <td>{{ $item->deliveryRequest->code }}</td>
                <td><a class="btn btn-success" href="delivery-note/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $deliveryNotes->links() }}
    </div>
 </div>
@stop

@section('footer')
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/delivery-note/create">Buat Baru</a>
    </div>
@stop



