@extends('adminlte::page')
@section('title', 'Perintah Produksi')

@section('content_header')
    <h1>Perintah Produksi</h1>
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
<table id="production-order-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="production-order-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="production-order-table" rowspan="1" colspan="1" >No. Perintah Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="production-order-table" rowspan="1" colspan="1" >Tanggal Perintah Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="production-order-table" rowspan="1" colspan="1" >Tipe Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="production-order-table" rowspan="1" colspan="1" >Status Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="production-order-table" rowspan="1" colspan="1" >Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productionOrders as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                @if ($item->production_type==1)
                <td>Barang Jadi</td>
                @else
                <td>Bahan Baku</td>
                @endif
                @if ($item->status==1) <td>Baru</td>
                @elseif ($item->status==2) <td>Dikirim</td>
                @else <td>Ditutup</td>
                @endif
                <td><a class="btn btn-success" href="production-order/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $productionOrders->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/production-order/create">Buat Baru</a>
    </div>
</div>
@stop

