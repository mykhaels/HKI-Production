@extends('adminlte::page')
@section('title', 'Penghapusan Pembelian')

@section('content_header')
    <h1>Penghapusan Pembelian</h1>
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
<table id="writeoff-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="writeoff-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="writeoff-table" rowspan="1" colspan="1" >No Kode Penghapusan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="writeoff-table" rowspan="1" colspan="1" >Tanggal Penghapusan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="writeoff-table" rowspan="1" colspan="1" >Nilai Penghapusan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="writeoff-table" rowspan="1" colspan="1" >Kode - Nama Supplier</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="writeoff-table" rowspan="1" colspan="1" >Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($writeoffs as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->supplier->code }} - {{ $item->supplier->name }}</td>
                <td><a class="btn btn-success" href="writeoff/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $writeoffs->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/writeoff/create">Buat Baru</a>
    </div>
</div>
@stop

