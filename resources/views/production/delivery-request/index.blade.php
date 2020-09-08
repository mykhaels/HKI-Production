@extends('adminlte::page')
@section('title', 'Permintaan Pengiriman Bahan Baku')

@section('content_header')
    <h1>Permintaan Pengiriman Bahan Produksi</h1>
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
<table id="delivery-request-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-request-table" rowspan="1" colspan="1">#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-request-table" rowspan="1" colspan="1">No. Permintaan Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-request-table" rowspan="1" colspan="1">Tanggal Permintaan Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-request-table" rowspan="1" colspan="1">Tipe Produk</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-request-table" rowspan="1" colspan="1">No. Perintah Produksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="delivery-request-table" rowspan="1" colspan="1">Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deliveryRequests as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ $item->transaction_date }}</td>
                @if ($item->product_type==2)
                <td>Bahan Baku</td>
                @else
                <td>Pendukung</td>
                @endif
                <td>{{ $item->productionOrder->code }}</td>
                <td><a class="btn btn-success" href="delivery-request/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row">
    <div class="col-12 pagination">
        {{ $deliveryRequests->links()  }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/delivery-request/create">Buat Baru</a>
    </div>
</div>
@stop

