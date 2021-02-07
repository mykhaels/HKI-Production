@extends('adminlte::page')
@section('title', 'Penerimaan Pembelian')

@section('content_header')
    <h1>Penerimaan Pembelian</h1>
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
<table id="good-receipt-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="good-receipt-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="good-receipt-table" rowspan="1" colspan="1" >No Kode BPB</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="good-receipt-table" rowspan="1" colspan="1" >Tanggal BPB</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="good-receipt-table" rowspan="1" colspan="1" >Kode PO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="good-receipt-table" rowspan="1" colspan="1" >Kode - Nama Supplier</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="good-receipt-table" rowspan="1" colspan="1" >Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($goodReceipts as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->purchaseOrder->code }}</td>
                <td>{{ $item->supplier->code }} - {{ $item->supplier->name }}</td>
                <td><a class="btn btn-success" href="good-receipt/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $goodReceipts->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/good-receipt/create">Buat Baru</a>
    </div>
</div>
@stop

