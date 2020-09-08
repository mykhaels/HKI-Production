@extends('adminlte::page')
@section('title', 'Produk')

@section('content_header')
    <h1>Produk</h1>
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
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Kode - Nama Produk</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Kategori Produk</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Tipe Produk</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Status Produk</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Lihat Detail</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="product-table" rowspan="1" colspan="1" >Hapus</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }} - {{ $item->name }}</td>
                <td>{{ $item->productCategory->product_category }}</td>
                @if ($item->product_type==1)
                <td>Barang Jadi</td>
                @elseif ($item->product_type==2)
                <td>Bahan Baku</td>
                @else
                <td>Pendukung</td>
                @endif

                @if ($item->status==1)
                    <td>Aktif</td>
                @else
                    <td>Tidak Aktif</td>
                @endif
                <td><a class="btn btn-success" href="product/{{ $item->id }}">Lihat Detail</a></td>
                <td>
                    <form action="product/{{ $item->id }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $products->links() }}
    </div>
 </div>
@stop
@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/product/create">Buat Baru</a>
    </div>
</div>
@stop
