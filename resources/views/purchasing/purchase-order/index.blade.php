@extends('adminlte::page')
@section('title', 'Pesanan Pembelian')

@section('content_header')
    <h1>Pesanan Pembelian</h1>
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
<table id="purchase-order-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >No Kode PO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >Tanggal PO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >Kode - Nama Supplier</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >Nilai PO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >Status PO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >Lihat Detail</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="purchase-order-table" rowspan="1" colspan="1" >Batal PO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchaseOrders as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->supplier->code }} - {{ $item->supplier->name }}</td>
                <td>{{ $item->total }}</td>
                @if ($item->status==1) <td>Menunggu</td>
                @elseif ($item->status==2) <td>Batal</td>
                @else <td>Terproses</td>
                @endif
                <td><a class="btn btn-success" href="purchase-order/{{ $item->id }}">Lihat Detail</a></td>
                <td>
                    <form action="purchase-order/updateStatus/{{ $item->id }}" method="post">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success" @if ($item->status!=1) disabled @endif>Batal PO</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $purchaseOrders->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/purchase-order/create">Buat Baru</a>
    </div>
</div>
@stop

