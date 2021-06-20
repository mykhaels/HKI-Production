@extends('adminlte::page')
@section('title', 'Pelunasan Penjualan')

@section('content_header')
    <h1>Pelunasan Penjualan</h1>
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
<table id="settlement-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="settlement-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="settlement-table" rowspan="1" colspan="1" >No Kode Pelunasan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="settlement-table" rowspan="1" colspan="1" >Tanggal Pelunasan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="settlement-table" rowspan="1" colspan="1" >Nilai Pelunasan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="settlement-table" rowspan="1" colspan="1" >Kode - Nama Pelanggan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="settlement-table" rowspan="1" colspan="1" >Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salesSettlements as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->customer->code }} - {{ $item->customer->name }}</td>
                <td><a class="btn btn-success" href="sales-settlement/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $salesSettlements->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/sales-settlement/create">Buat Baru</a>
    </div>
</div>
@stop

