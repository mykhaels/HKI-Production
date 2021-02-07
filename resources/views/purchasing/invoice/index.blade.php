@extends('adminlte::page')
@section('title', 'Faktur Pembelian')

@section('content_header')
    <h1>Faktur Pembelian</h1>
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
<table id="invoice-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >No Kode Faktur</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Tanggal Faktur</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Nilai Faktur</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Kode BPB</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Kode PO</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Kode - Nama Supplier</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Status Faktur</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Lihat Detail</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="invoice-table" rowspan="1" colspan="1" >Batal Faktur</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->goodReceipt->code }}</td>
                <td>{{ $item->goodReceipt->purchaseOrder->code }}</td>
                <td>{{ $item->supplier->code }} - {{ $item->supplier->name }}</td>
                @if ($item->status==1) <td>Belum Lunas</td>
                @elseif ($item->status==2) <td>Lunas</td>
                @else <td>Batal</td>
                @endif
                <td><a class="btn btn-success" href="invoice/{{ $item->id }}">Lihat Detail</a></td>
                <td>
                    <form action="invoice/updateStatus/{{ $item->id }}" method="post">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success">Batal Faktur</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $invoices->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/invoice/create">Buat Baru</a>
    </div>
</div>
@stop

