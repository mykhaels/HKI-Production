@extends('adminlte::page')
@section('title', 'Insert Surat Jalan')

@section('content_header')
    <h1>Insert Surat Jalan</h1>
@stop


@section('content')
<form method="post" action="/sales-delivery-note">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode SJ</label>
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
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal SJ</label>
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
        <label for="supplier" class="col-sm-2 col-form-label">Pelanggan</label>
        <div  class="col-sm-2">
            <select class="form-control  @error('customer_id') is-invalid @enderror" id="customer" name="customer_id">
                <option value="0">--Pilih--</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('customer_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="so" class="col-sm-2 col-form-label">Kode SO</label>
        <div  class="col-sm-2">
            <select class="form-control @error('sales_order_id') is-invalid @enderror" id="so" name="sales_order_id" >
                <option value="0">--Pilih--</option>
            </select>
            @error('sales_order_id')
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
    <div class="table-ressonsive-md">
        <table class="table" id="details_table">
            <thead>
                <tr scope="row" class="d-flex">
                    <th scope="col" class="col-4">Kode-Nama Produk</th>
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
            <a href="/sales-delivery-note"><button type="button" class="btn btn-primary">Kembali</button></a>
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

    var so = $('#so');
    so.change(function(){
        $('#details_table tbody').empty();
        if(so.val()!=0){
            $.ajax({
                method : "GET",
                url : "{{ url('/initial-payment-sales/getSalesOrder')}}",
                data:{'id':so.val()},
                success:function(response){
                    $.each(response.sales_order_details, function(index,item){
                        let row =  '<tr scope="row" class="d-flex">'
                            +'<td scope="col"  class="col-4">'
                                +'<div class="row">'
                                    +'<div class="col">'
                                        +'<input type="input" name="codes[]" class="form-control"  readonly value="'+item.product.code+'-'+item.product.name+'"/>'
                                        +'<input type="hidden" name="products[]" style="display:none" readonly value="'+item.product.id+'"/>'
                                    +'</div>'
                                +'</div>'
                            +'</td>'
                            +'<td scope="col" class="col-4"><input type="number" name="quantities[]" class="form-control @error("quantities.*") is-invalid @enderror" value="'+item.qty+'" oninput="validity.valid||(value=\'0\');"/></td>'
                            +'<td scope="col" class="col-4">'
                                +'<select class="form-control" id="uom" disabled> '
                                    +'<option value="'+item.uom.id+'">'+item.uom.name+'</option>'
                                +'</select>'
                                +'<input type="hidden" name="uoms[]" class="form-control" value="'+item.uom.id+'" readonly />'
                            +'</td>'
                            +'<input type="hidden" name="qtySO[]"  value="'+item.qty+'" readonly />'
                        +'</tr>';
                        $('#details_table tbody').append(row);
                    });
                }
            });
        }
    });

    $('#customer').change(function(){
        $('#details_table tbody').empty();
        $('#so').find('option').remove().end();
        $('#so').append($(new Option("--Pilih--", 0)));
        $.ajax({
            method : "GET",
            url : "{{ url('/sales-delivery-note/getListSOCustomer')}}",
            data:{'id':$(this).val()},
            success:function(response){
                $.each(response.salesOrders, function(index,item){
                    $('#so').append($(new Option(item.code, item.id)));
                });
            }
        });
    });
</script>
@stop

