@extends('adminlte::page')
@section('title', 'Detail Permintaan Tranfer Barang')

@section('content_header')
    <h1>Detail Permintaan Tranfer Barang</h1>
@stop

@section('content')
<form method="post" action="/transfer-request">
    @csrf
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            <select class="form-control" id="product_type" name="product_type" disabled>
                <option value="2" @if ($transferRequest->product_type == 2)
                    selected
                @endif>Bahan Baku</option>
                <option value="3" @if ($transferRequest->product_type == 3)
                    selected
                @endif>Pendukung</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">No Permintaan</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $transferRequest->code }}" disabled>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Permintaan</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ $transferRequest->transaction_date }}" disabled>
            @error('transaction_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="delivery_date" class="col-sm-2 col-form-label">Tanggal Permintaan Kirim</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date"  name="delivery_date" value="{{ $transferRequest->delivery_date }}" disabled>
            @error('delivery_date')
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
            @foreach ($transferRequest->transferRequestDetails as $item)
            <tr scope="row">
                <td scope="col">
                    <div class="row">
                        <div class="col">
                            <input type="input" name="codes[]" class="form-control"  readonly value="{{ $item->product->code }}-{{ $item->product->name }}"/>
                            <input type="hidden" name="products[]" style="display:none" readonly value="{{ $item->product->id }}"/>
                        </div>
                    </div>
                </td>
                <td scope="col"><input type="number" name="quantities[]" class="form-control" value="{{ $item->qty }}" readonly /></td>
                <td scope="col">
                    <select class="form-control" id="uom" name="uoms[]" readonly>
                        <option value="{{ $item->uom->id }}">{{ $item->uom->name }}</option>
                    </select>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('footer')
<div class="row">
    <div class="col-2">
        <a href="/transfer-request"><button type="button" class="btn btn-primary">Kembali</button></a>
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
            url : "{{ url('/transfer-request/get-delivery-request')}}",
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
