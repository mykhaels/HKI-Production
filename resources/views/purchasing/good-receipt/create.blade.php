@extends('adminlte::page')
@section('title', 'Insert Penerimaan Pembelian')

@section('content_header')
    <h1>Insert Penerimaan Pembelian</h1>
@stop


@section('content')
<form method="post" action="/good-receipt">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode BPB</label>
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
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal BPB</label>
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
        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
        <div  class="col-sm-2">
            <select class="form-control  @error('supplier_id') is-invalid @enderror" id="supplier" name="supplier_id">
                <option value="0">--Pilih--</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
            @error('supplier_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="po" class="col-sm-2 col-form-label">Kode PO</label>
        <div  class="col-sm-2">
            <select class="form-control @error('purchase_order_id') is-invalid @enderror" id="po" name="purchase_order_id" >
                <option value="0">--Pilih--</option>
            </select>
            @error('purchase_order_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    @error('quantities.*')
    <div class="invalid-feedback d-flex">
        {{ $message }}
    </div>
    @enderror
    <div class="table-responsive-md">
        <table class="table" id="details_table">
            <thead>
                <tr scope="row" class="d-flex">
                    <th scope="col" class="col-4">Kode-Nama Bahan</th>
                    <th scope="col" class="col-4">Qty</th>
                    <th scope="col" class="col-4">Satuan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


    @stop

    @section('footer')
    <div class="row">
        <div class="col-2">
            <a href="/good-receipt"><button type="button" class="btn btn-primary">Kembali</button></a>
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

    var po = $('#po');
    po.change(function(){
        $('#details_table tbody').empty();
        if(po.val()!=0){
            $.ajax({
                method : "GET",
                url : "{{ url('/initial-payment/getPurchaseOrder')}}",
                data:{'id':po.val()},
                success:function(response){
                    $.each(response.purchase_order_details, function(index,item){
                        let row =  '<tr scope="row" class="d-flex">'
                            +'<td scope="col"  class="col-4">'
                                +'<div class="row">'
                                    +'<div class="col">'
                                        +'<input type="input" name="codes[]" class="form-control"  readonly value="'+item.product.code+'-'+item.product.name+'"/>'
                                        +'<input type="hidden" name="products[]" style="display:none" readonly value="'+item.product.id+'"/>'
                                    +'</div>'
                                +'</div>'
                            +'</td>'
                            +'<td scope="col" class="col-4"><input type="number" name="quantities[]" class="form-control @error("quantities.*") is-invalid @enderror" value="'+item.qty+'"/></td>'
                            +'<td scope="col" class="col-4">'
                                +'<select class="form-control" id="uom" name="uoms[]" readonly> '
                                    +'<option value="'+item.uom.id+'">'+item.uom.name+'</option>'
                                +'</select>'
                            +'</td>'
                            +'<input type="hidden" name="qtyPO[]"  value="'+item.qty+'" readonly />'
                        +'</tr>';
                        $('#details_table tbody').append(row);
                    });
                }
            });
        }
    });

    $('#supplier').change(function(){
        $('#details_table tbody').empty();
        $('#po').find('option').remove().end();
        $('#po').append($(new Option("--Pilih--", 0)));
        $.ajax({
            method : "GET",
            url : "{{ url('/initial-payment/getListPOSupplier')}}",
            data:{'id':$(this).val()},
            success:function(response){
                $.each(response.purchaseOrders, function(index,item){
                    $('#po').append($(new Option(item.code, item.id)));
                });
            }
        });
    });
</script>
@stop

