@extends('adminlte::page')
@section('title', 'Kategori Produk')

@section('content_header')
    <h1>Kategori Produk</h1>
@stop

@section('content')
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            <select class="form-control" id="productType" name="product_type" disabled>
                <option value="1" @if ($productCategory->product_type == 1)
                    selected
                @endif>Barang Jadi</option>
                <option value="2" @if ($productCategory->product_type == 2)
                    selected
                @endif>Bahan Baku</option>
                <option value="3" @if ($productCategory->product_type == 3)
                    selected
                @endif>Pendukung</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="category" class="col-sm-2 col-form-label">Kategori Produk</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('product_category') is-invalid @enderror" id="category"  name="product_category" value="{{ $productCategory->product_category }}" readonly>
            @error('product_category')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
@stop
@section('footer')
<div class="row">
    <div class="col-2">
        <a href="/product-category"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
    <div class="col-10 text-right">
        <a class="btn btn-primary" href="/product-category/{{ $productCategory->id }}/edit">Ubah</a>
    </div>
</div>
@stop
