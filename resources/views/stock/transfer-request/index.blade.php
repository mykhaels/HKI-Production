@extends('adminlte::page')
@section('title', 'Permintaan Pengiriman Barang')

@section('content_header')
    <h1>Permintaan Pengiriman Barang</h1>
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
<table class="table table-bordered table-hover dataTable dtr-inline" role="grid" id="transfer-request-table">
    <thead>
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-request-table" rowspan="1" colspan="1">#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-request-table" rowspan="1" colspan="1">Kode Permintaan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-request-table" rowspan="1" colspan="1">Tanggal Permintaan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-request-table" rowspan="1" colspan="1">Tanggal Permintaan Kirim</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-request-table" rowspan="1" colspan="1">Lihat Detail</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="transfer-request-table" rowspan="1" colspan="1">Batal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transferRequests as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                <td>{{ date('d-M-Y', strtotime($item->delivery_date)) }}</td>
                <td><a class="btn btn-success" href="transfer-request/{{ $item->id }}">Lihat Detail</a></td>
                <td>
                    <form action="transfer-request/updateStatus/{{ $item->id }}" method="post">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success" @if ($item->status!=1) disabled @endif>Batal Permintaan</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $transferRequests->links() }}
    </div>
 </div>
@stop

@section('footer')
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/transfer-request/create">Buat Baru</a>
    </div>
@stop



