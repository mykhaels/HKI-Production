@extends('adminlte::page')
@section('title', 'Insert Hasil Produksi')

@section('content_header')
    <h1>INSERT HASIL PRODUKSI</h1>
@stop
@section('content')
<form method="post" action="/production-result">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">No Hasil Produksi</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $generatedCode }}" readonly>
            <input type="hidden" id="production_type"  name="production_type">
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Hasil Produksi</label>
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
        <label for="production_order_id" class="col-sm-2 col-form-label">No Perintah Produksi</label>
        <div  class="col-sm-2">
            <select class="form-control @error('production_order_id') is-invalid @enderror" id="production_order_id" name="production_order_id">
                <option value="0">--Pilih--</option>
                @foreach ($deliveryRequests as $deliveryRequest)
                    <option value="{{ $deliveryRequest->productionOrder->id }}">{{ $deliveryRequest->productionOrder->code }}</option>
                @endforeach
            </select>
            @error('production_order_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <table class="table" id="details_table">
        <thead>
            <tr>
                <th scope="col">Kode-Nama Barang</th>
                <th scope="col">Qty</th>
                <th scope="col">Satuan</th>
                <th scope="col">Hapus</th>
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
    var prodOrder = $('#production_order_id');
    prodOrder.change(function(){
        $('#details_table tbody').empty();
        if(prodOrder.val()!=0){
            $.ajax({
            method : "GET",
            url : "{{ url('/production-result/get-production-order')}}",
            data:{'id':prodOrder.val()},
            success:function(response){
                $('#production_type').val(response.production_type);
                $.each(response.production_order_details, function(index,item){
                    let row =  '<tr scope="row">'
                        +'<td scope="col">'
                            +'<div class="row">'
                                +'<div class="col">'
                                    +'<input type="input" name="codes[]" class="form-control"  readonly value="'+item.product.code+'-'+item.product.name+'"/>'
                                    +'<input type="hidden" name="products[]" style="display:none" readonly value="'+item.product.id+'"/>'
                                +'</div>'
                            +'</div>'
                        +'</td>'
                        +'<td scope="col"><input type="number" name="quantities[]" class="form-control" value="'+item.qty+'"/></td>'
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
