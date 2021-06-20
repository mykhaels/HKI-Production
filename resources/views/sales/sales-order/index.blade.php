@extends('adminlte::page')
@section('title', 'Pesanan Penjualan')

@section('content_header')
    <h1>Pesanan Penjualan</h1>
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
<table id="sales-order-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >No Kode SO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >Tanggal SO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >Kode - Nama Pelanggan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >Nilai SO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >Status SO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >Lihat Detail</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-order-table" rowspan="1" colspan="1" >Batal SO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salesOrders as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->customer->code }} - {{ $item->customer->name }}</td>
                <td>{{ $item->total }}</td>
                @if ($item->status==1) <td>Menunggu</td>
                @elseif ($item->status==2) <td>Batal</td>
                @else <td>Terproses</td>
                @endif
                <td><a class="btn btn-success" href="sales-order/{{ $item->id }}">Lihat Detail</a></td>
                <td>
                    <form action="sales-order/updateStatus/{{ $item->id }}" method="post">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success" @if ($item->status!=1) disabled @endif>Batal SO</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $salesOrders->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/sales-order/create">Buat Baru</a>
    </div>
</div>
@stop

