@extends('adminlte::page')
@section('title', 'Insert Pengeluaran Produksi')

@section('content_header')
    <h1>Insert Pengeluaran Produksi</h1>
@stop

@section('content')
<form method="post" action="/delivery-note">
    @csrf
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            <select class="form-control" id="product_type" name="product_type" disabled>
            <option value="2">Bahan Baku</option>
            <option value="3">Pendukung</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">Tipe Pengeluaran</label>
        <div  class="col-sm-2">
            <select class="form-control" id="delivery_type" name="delivery_type">
            <option value="1">Produksi</option>
            <option value="2">Bahan Penolong</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">No Pengeluaran</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $generatedCode }}" readonly>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Pengeluaran</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ old('transaction_date') }}">
            @error('transaction_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">No Permintaan Produksi</label>
        <div  class="col-sm-2">
            <select class="form-control @error('delivery_request_id') is-invalid @enderror" id="delivery_request_id" name="delivery_request_id">
                <option value="0">--Pilih--</option>
                @foreach ($deliveryRequests as $deliveryRequest)
                    <option value="{{ $deliveryRequest->id }}">{{ $deliveryRequest->code }}</option>
                @endforeach
            </select>
            @error('delivery_request_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <table class="table" id="details_table">
        <thead>
            <tr>
                <th scope="col">Kode-Nama Bahan</th>
                <th scope="col">Qty</th>
                <th scope="col">Satuan</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
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

@section('js')
<script>
     $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

    var delRequest = $('#delivery_request_id');
    delRequest.change(function(){
        $('#details_table tbody').empty();
        if(delRequest.val()!=0){
            $.ajax({
            method : "GET",
            url : "{{ url('/delivery-note/get-delivery-request')}}",
            data:{'id':delRequest.val()},
            success:function(response){
                $('#product_type').val(response.product_type);
                $.each(response.delivery_request_details, function(index,item){
                    let row =  '<tr scope="row">'
                        +'<td scope="col">'
                            +'<div class="row">'
                                +'<div class="col">'
                                    +'<input type="input" name="codes[]" class="form-control"  readonly value="'+item.product.code+'-'+item.product.name+'"/>'
                                    +'<input type="hidden" name="products[]" style="display:none" readonly value="'+item.product.id+'"/>'
                                +'</div>'
                            +'</div>'
                        +'</td>'
                        +'<td scope="col"><input type="number" name="quantities[]" class="form-control" value="'+item.qty+'" readonly /></td>'
                        +'<td scope="col">'
                            +'<select class="form-control" id="uom" name="uoms[]" readonly> '
                                +'<option value="'+item.uom.id+'">'+item.uom.name+'</option>'
                            +'</select>'
                        +'</td>'
                    +'</tr>';
                    $('#details_table tbody').append(row);
                });
                }
            });
        }
    });
</script>
@stop
