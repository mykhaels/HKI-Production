@extends('adminlte::page')
@section('title', 'Kategori Produk')

@section('content_header')
    <h1>Kategori Produk</h1>
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
<div class="row">
    <div class="col-sm-12">
        <table id="category-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid" >
            <thead>
                <tr>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="category-table" rowspan="1" colspan="1" aria-label="Number: activate to sort column ascending">#</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="category-table" rowspan="1" colspan="1" aria-label="Kategori Produk: activate to sort column ascending">Kategori Produk</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="category-table" rowspan="1" colspan="1" aria-label="Tipe Produk: activate to sort column ascending">Tipe Produk</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="category-table" rowspan="1" colspan="1" aria-label="Status Produk: activate to sort column ascending">Status Produk</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="category-table" rowspan="1" colspan="1" aria-label="Status Produk: activate to sort column ascending">Lihat Detail</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="category-table" rowspan="1" colspan="1" aria-label="Ubah Status: activate to sort column ascending">Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->product_category }}</td>
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

                        <td><a class="btn btn-success" href="product-category/{{ $item->id }}">Lihat Detail</a></td>
                        <td>
                            <form action="product-category/status/{{ $item->id }}" method="post">
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
                {{ $categories->links() }}
            </div>
         </div>
    </div>
</div>
@stop



@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <a class="btn btn-primary" href="/product-category/create">Buat Baru</a>
    </div>
</div>
@stop

