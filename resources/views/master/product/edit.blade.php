@extends('adminlte::page')
@section('title', 'Edit Produk')

@section('content_header')
    <h1>EDIT PRODUK</h1>
@stop

@section('content')
<form method="post" action="/product/{{ $product->id }}">
    @method('patch')
    @csrf
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            <select class="form-control" id="productType" name="product_type">
                <option value="1" @if ($product->product_type == 1)
                    selected
                @endif>Barang Jadi</option>
                <option value="2" @if ($product->product_type == 2)
                    selected
                @endif>Bahan Baku</option>
                <option value="3" @if ($product->product_type == 3)
                    selected
                @endif>Pendukung</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="category" class="col-sm-2 col-form-label">Kategori Produk</label>
        <div  class="col-sm-2">
            <select class="form-control @error('product_category_id') is-invalid @enderror" id="product_category_id" name="product_category_id">
                @foreach ($productCategories as $productCategory)
                    <option value="{{ $productCategory->id }}" @if ($product->product_category_id == $productCategory->id)
                        selected
                    @endif>{{ $productCategory->product_category }}</option>
                @endforeach
            </select>
            @error('product_category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Produk</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $product->code }}" readonly>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Nama Produk</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"  name="name" value="{{ $product->name }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="button" class="btn btn-primary col-md-2 offset-md-5" id="add_row" float="right">
            Tambah data
        </button>
    </div>
    <table class="table" id="products_table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Satuan</th>
                <th scope="col">Nilai Konversi</th>
                <th scope="col">Tingkat</th>
                <th scope="col">Harga</th>
                <th scope="col">Hapus</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $product->uoms as $detail )
                <tr>
                    <td>
                        <select class="form-control" id="uom" name="uoms[]">
                        @foreach ($uoms as $uom)
                            <option value="{{ $uom->id }}"
                                @if ($detail->id == $uom->id)
                                selected
                            @endif>{{ $uom->name }}</option>
                        @endforeach
                        </select>
                    </td>
                <td><input type="number" name="conversions[]" class="form-control" value="{{ $detail->pivot->conversion }}" /></td>
                    <td><input type="number" name="level[]" class="form-control" value="{{ $detail->pivot->level }}" /></td>
                    <td><input type="number" name="price[]" class="form-control" value="{{ $detail->pivot->price }}" /></td>
                    <td><button class="btn btn-danger" onclick="deleteRow(this)">Hapus</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('footer')

<div class="row">
    <div class="col-2">
        <a href="/product"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
    <div class="col-10 text-right">
        <button type="submit" class="btn btn-primary">Simpan</a>
    </div>
</div>
</form>

@stop

@section('js')
<script>
    let row =  '<tr>'
                +'<td>'
                   + '<select class="form-control" id="uom" name="uoms[]">'
                   + '@foreach ($uoms as $uom)'
                   +    '<option value="{{ $uom->id }}">{{ $uom->name }}</option>'
                   +'@endforeach'
                   +'</select>'
                +'</td>'
                +'<td><input type="number" name="conversions[]" class="form-control" value="1" /></td>'
                +'<td><input type="number" name="level[]" class="form-control" value="1" /></td>'
                +'<td><input type="number" name="price[]" class="form-control" value="100" /></td>'
                +'<td><button class="btn btn-danger" onclick="deleteRow(this)">Hapus</button></td>'
                +'</tr>';

    let row_number = 1;
    $("#add_row").click(function(e){
        e.preventDefault();
        $('#products_table').append(row);
    });


    function deleteRow(e){
        $(e).parent().parent().remove();
    }


    $('#productType').change(function(){
        var id = document.getElementById("productType").value;

        $.ajax({
            method: "GET",
            url: "{{ url('product-category/get-category') }}/"+id,
            success: function (response) {
                let productCategorySelect = $('#product_category_id');
                productCategorySelect.empty();
                productCategorySelect.append('<option selected="selected" value="0">--Pilih--</option>');
                $.each(response['data'], function(i, item) {
                    productCategorySelect.append($('<option>', {
                        value: item.id,
                        text: item.product_category
                    }));
                });
            }

        });
    });

</script>
@stop
