@extends('adminlte::page')
@section('title', 'Insert Faktur Pembelian')

@section('content_header')
    <h1>Insert Faktur Pembelian</h1>
@stop

@section('content')
<form method="post" action="/invoice">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Faktur</label>
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
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Faktur</label>
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
        <label for="po" class="col-sm-2 col-form-label">Kode BPB</label>
        <div  class="col-sm-2">
            <select class="form-control @error('good_receipt_id') is-invalid @enderror" id="bpb" name="good_receipt_id" >
                <option value="0">--Pilih--</option>
            </select>
            @error('good_receipt_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>


    <div class="table-responsive-md">
    <table class="table" id="details_table">
        <thead>
            <tr scope="row" class="d-flex">
                <th scope="col" class="col-3">Kode-Nama Bahan</th>
                <th scope="col" class="col-1">Qty</th>
                <th scope="col" class="col-2">Satuan</th>
                <th scope="col" class="col-2">Harga</th>
                <th scope="col" class="col-1">Diskon</th>
                <th scope="col" class="col-1">Status Pajak</th>
                <th scope="col" class="col-2">Total</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="form-group d-flex justify-content-end">
    <label for="subtotal-input" class="col-md-1 m-1">Sub Total</label>
    <input type="input" class="form-control col-md-2" id="subtotal-input" name="subtotal" readonly value="0">
</div>
<div class="form-group d-flex justify-content-end">
    <label for="ppn-input" class="col-md-1 m-1">PPN</label>
    <input type="input" class="form-control col-md-2" id="ppn-input" name="ppn" readonly value="0">
</div>
<div class="form-group d-flex justify-content-end">
    <label for="dp-input" class="col-md-1 m-1">DP</label>
    <input type="input" class="form-control col-md-2" id="dp-input" name="dp" readonly value="0">
</div>
<div class="form-group d-flex justify-content-end">
    <label for="total-input" class="col-md-1 m-1">Total</label>
    <input type="input" class="form-control col-md-2" id="total-input" name="total" readonly value="0">
</div>
@stop



@section('footer')
<div class="row">
    <div class="col-2">
        <a href="/invoice"><button type="button" class="btn btn-primary">Kembali</button></a>
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

    var bpb = $('#bpb');
    bpb.change(function(){
        $('#details_table tbody').empty();
        $('#subtotal-input').val(0);
        $('#ppn-input').val(0);
        $('#total-input').val(0);
        $('#dp-input').val(0);
        if(bpb.val()!=0){
            $.ajax({
                method : "GET",
                url : "{{ url('/invoice/getGoodReceiptPO')}}",
                data:{'id':bpb.val()},
                success:function(response){
                    $.each(response.purchase_order.purchase_order_details, function(index,item){
                        let qty = item.qty;
                        $.each(response.good_receipt_details, function(indexGd,i){
                            if(item.product.id=i.product.id){
                                qty=i.qty;
                            }
                        });
                        let tax = item.tax_status==1 ? "ya" : "tidak";
                        let row =  '<tr scope="row" class="d-flex">'
                            +'<td scope="col"  class="col-3">'
                                +'<div class="row">'
                                    +'<div class="col">'
                                        +'<input type="input" name="codes[]" class="form-control"  readonly value="'+item.product.code+'-'+item.product.name+'"/>'
                                        +'<input type="hidden" name="products[]" style="display:none" readonly value="'+item.product.id+'"/>'
                                    +'</div>'
                                +'</div>'
                            +'</td>'
                            +'<td scope="col" class="col-1"><input type="number" name="quantities[]" class="form-control" value="'+qty+'" readonly /></td>'
                            +'<td scope="col" class="col-2">'
                                +'<select class="form-control" id="uom" disabled> '
                                    +'<option value="'+item.uom.id+'">'+item.uom.name+'</option>'
                                +'</select>'
                                +'<input type="hidden" name="uoms[]" class="form-control" value="'+item.uom.id+'" />'
                            +'</td>'
                            +'<td scope="col" class="col-2"><input type="number" name="prices[]" class="form-control" value="'+item.price+'" readonly /></td>'
                            +'<td scope="col" class="col-1"><input type="number" name="discounts[]" class="form-control" value="'+item.discount+'" readonly /></td>'
                            +'<td scope="col" class="col-1"><input type="input"  class="form-control" value="'+tax+'" readonly /><input type="hidden" name="taxs[]" class="form-control" value="'+item.tax_status+'" readonly /></td>'
                            +'<td scope="col" class="col-2"><input type="input" name="totals[]" class="form-control" value="'+item.total+'" readonly /></td>'
                        +'</tr>';
                        $('#details_table tbody').append(row);
                    });
                    let dp = 0;
                    let subtotal = parseInt(response.purchase_order.subtotal);
                    let ppn = parseInt(response.purchase_order.ppn);
                    if(response.purchase_order.initial_payment!=null) dp=parseInt(response.purchase_order.initial_payment.dp);
                    let total = subtotal+ppn-dp;
                    $('#subtotal-input').val(response.purchase_order.subtotal);
                    $('#ppn-input').val(response.purchase_order.ppn);
                    $('#dp-input').val(dp);
                    $('#total-input').val(total);
                }
            });
        }
    });

    $('#supplier').change(function(){
        $('#details_table tbody').empty();
        $('#subtotal-input').val(0);
        $('#ppn-input').val(0);
        $('#total-input').val(0);
        $('#dp-input').val(0);
        $('#bpb').find('option').remove().end();
        $('#bpb').append($(new Option("--Pilih--", 0)));
        $.ajax({
            method : "GET",
            url : "{{ url('/invoice/getListBPBSupplier')}}",
            data:{'id':$(this).val()},
            success:function(response){
                $.each(response.goodReceipts, function(index,item){
                    $('#bpb').append($(new Option(item.code, item.id)));
                });
            }
        });
    });
</script>
@stop
