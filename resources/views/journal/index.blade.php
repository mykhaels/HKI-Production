@extends('adminlte::page')
@section('title', 'Jurnal')

@section('content_header')
    <h1>Jurnal</h1>
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
<table id="journal-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead>
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1" >Kode Transaksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1" >Tanggal Transaksi</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1" >Lihat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($journals as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ $item->transaction_date }}</td>
                <td><a class="btn btn-success" href="journal/{{ $item->id }}">Lihat Detail</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $journals->links() }}
    </div>
 </div>
@stop
@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/journal/create">Buat Baru</a>
    </div>
</div>
@stop
