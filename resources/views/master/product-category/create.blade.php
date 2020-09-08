@extends('adminlte::page')
@section('title', 'Insert Kategori Produk')

@section('content_header')
    <h1>Insert Kategori Produk</h1>
@stop

@section('content')
<form method="post" action="/product-category">
    @csrf
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            <select class="form-control" id="productType" name="product_type">
            <option value="1">Barang Jadi</option>
            <option value="2">Bahan Baku</option>
            <option value="3">Pendukung</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="category" class="col-sm-2 col-form-label">Kategori Produk</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('product_category') is-invalid @enderror" id="category"  name="product_category" value="{{ old('product_category') }}">
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
        <button type="button" class="btn btn-primary">Kembali</button>
    </div>
    <div class="col-10 text-right">
        <button type="submit" class="btn btn-primary">Simpan</a>
    </div>
</div>
</form>
@stop
