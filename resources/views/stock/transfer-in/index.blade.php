@extends('adminlte::page')
@section('title', 'Penerimaan Transfer Barang')

@section('content_header')
    <h1>Penerimaan Transfer Barang</h1>
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
<table class="table table-bordered table-hover dataTable dtr-inline" role="grid" id="transfer-in-table">
    <thead>
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Kode Penerimaan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Tanggal Penerimaan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Ref Kode Permintaan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Ref Tanggal Permintaan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-in-table" rowspan="1" colspan="1">Lihat Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transferIns as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ $item->transferRequest->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transferRequest->transaction_date)) }}</td>
                <td><a class="btn btn-success" href="transfer-in/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $transferIns->links() }}
    </div>
 </div>
@stop

@section('footer')
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/transfer-in/create">Buat Baru</a>
    </div>
@stop



