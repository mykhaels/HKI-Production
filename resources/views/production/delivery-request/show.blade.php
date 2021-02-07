@extends('adminlte::page')
@section('title', 'Detail Permintaan Pengiriman Bahan Baku')

@section('content_header')
    <h1>DETAIL PERMINTAAN PENGIRIMAN BAHAN BAKU</h1>
@stop

@section('content')
<form method="post" action="/delivery-request">
    @csrf
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            <select class="form-control" id="productType" name="product_type" disabled>
                <option value="1" @if ($deliveryRequest->product_type == 1)
                    selected
                @endif>Barang Jadi</option>
                <option value="2" @if ($deliveryRequest->product_type == 2)
                    selected
                @endif>Bahan Baku</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">No Perintah</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $deliveryRequest->code }}" disabled>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Perintah</label>
        <div  class="col-sm-2">
        <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ $deliveryRequest->transaction_date }}" disabled>
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
            <select class="form-control @error('production_order_id') is-invalid @enderror" id="production_order_id" name="production_order_id" disabled>
                <option value="{{ $deliveryRequest->productionOrder->id}}">{{ $deliveryRequest->productionOrder->code }}</option>
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
                <th scope="col">Kode-Nama Bahan</th>
                <th scope="col">Qty</th>
                <th scope="col">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deliveryRequest->deliveryRequestDetails as $item)
                <tr scope="row">
                    <td >
                        <div class="form-row">
                            <div class="col">
                                <input type="input" name="codes[]" value="{{ $item->product->code }}-{{ $item->product->name }}" class="form-control"  readonly />
                                <input type="hidden" name="products[]" class="form-control"  value="{{ $item->product_id }}" readonly />
                            </div>
                        </div>
                    </td>
                    <td><input type="number" name="quantities[]" value="{{ $item->qty }}" class="form-control"  disabled/></td>
                    <td>
                        <select class="form-control" id="uom" name="uoms[]" disabled>
                            <option value="{{ $item->uom_id }}">{{ $item->uom->name }}</option>
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
        <a href="/delivery-request"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
    <div class="col-10 text-right">
        <a href="{{ $deliveryRequest->id }}/pdf"><button type="button" class="btn btn-primary">Print</button></a>
    </div>
</div>
</form>
@stop

