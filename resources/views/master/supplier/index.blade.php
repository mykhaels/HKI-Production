@extends('adminlte::page')
@section('title', 'Supplier')

@section('content_header')
    <h1>Supplier</h1>
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
<table id="product-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead>
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Kode - Nama Supplier</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Status Supplier</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Lihat Detail</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Ubah Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }} - {{ $item->name }}</td>
                @if ($item->status==1)
                    <td>Aktif</td>
                @else
                    <td>Tidak Aktif</td>
                @endif
                <td><a class="btn btn-success" href="supplier/{{ $item->id }}">Lihat Detail</a></td>
                <td>
                    <form action="supplier/status/{{ $item->id }}" method="post">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success">Ubah Status</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $suppliers->links() }}
    </div>
 </div>
@stop
@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/supplier/create">Buat Baru</a>
    </div>
</div>
@stop
