@extends('adminlte::page')
@section('title', 'Uang Muka Pembelian')

@section('content_header')
    <h1>Uang Muka Pembelian</h1>
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
<table id="initial-payment-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >No Kode DP</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >Tanggal DP</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >Kode PO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >Kode - Nama Supplier</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >Nilai DP</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >Lihat Detail</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="initial-payment-table" rowspan="1" colspan="1" >Batal PO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($initialPayments as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->purchaseOrder->code }}</td>
                <td>{{ $item->supplier->code }} - {{ $item->supplier->name }}</td>
                <td>{{ $item->dp }}</td>
                <td><a class="btn btn-success" href="initial-payment/{{ $item->id }}">Lihat Detail</a></td>
                <td>
                    <form action="initial-payment/{{ $item->id }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-success">Batal DP</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $initialPayments->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/initial-payment/create">Buat Baru</a>
    </div>
</div>
@stop

