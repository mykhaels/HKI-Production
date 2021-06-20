@extends('adminlte::page')
@section('title', 'Surat Jalan')

@section('content_header')
    <h1>Surat Jalan</h1>
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
<table id="sales-delivery-note-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-delivery-note-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-delivery-note-table" rowspan="1" colspan="1" >No Kode SJ</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-delivery-note-table" rowspan="1" colspan="1" >Tanggal SJ</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-delivery-note-table" rowspan="1" colspan="1" >Kode SO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-delivery-note-table" rowspan="1" colspan="1" >Kode - Nama Pelanggan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="sales-delivery-note-table" rowspan="1" colspan="1" >Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salesDeliveryNotes as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->salesOrder->code }}</td>
                <td>{{ $item->customer->code }} - {{ $item->customer->name }}</td>
                <td><a class="btn btn-success" href="sales-delivery-note/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $salesDeliveryNotes->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/sales-delivery-note/create">Buat Baru</a>
    </div>
</div>
@stop

