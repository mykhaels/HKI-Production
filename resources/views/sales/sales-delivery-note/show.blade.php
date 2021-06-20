@extends('adminlte::page')
@section('title', 'Detail Surat Jalan')

@section('content_header')
    <h1>Detail Surat Jalan</h1>
@stop


@section('content')
<form method="post" action="/sales-delivery-note">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode SJ</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control"  name="code" value="{{ $salesDeliveryNote->code }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal SJ</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control" id="transaction_date"  name="transaction_date" value="{{ $salesDeliveryNote->transaction_date }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="customer" class="col-sm-2 col-form-label">Supplier</label>
        <div  class="col-sm-2">
            <select class="form-control" id="customer" name="customer_id" disabled>
                <option value="{{ $salesDeliveryNote->customer_id }}">{{ $salesDeliveryNote->customer->name }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="po" class="col-sm-2 col-form-label">Kode SO</label>
        <div  class="col-sm-2">
            <select class="form-control" id="po" name="purchase_order_id" disabled>
                <option value="{{ $salesDeliveryNote->salesOrder->id }}">{{ $salesDeliveryNote->salesOrder->code }}</option>
            </select>
        </div>
    </div>
    <div class="table-responsive-md">
        <table class="table" id="details_table">
            <thead>
                <tr scope="row" class="d-flex">
                    <th scope="col" class="col-4">Kode-Nama Produk</th>
                    <th scope="col" class="col-4">Qty</th>
                    <th scope="col" class="col-4">Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesDeliveryNote->salesDeliveryNoteDetails as $item)
                <tr scope="row" class="d-flex">
                    <td class="col-4">
                        <div class="form-row">
                            <div class="col">
                                <input type="input" name="codes[]" class="form-control"  readonly readonly value="{{ $item->product->code }}-{{ $item->product->name }}"/>
                                <input type="hidden" name="products[]" class="form-control"  readonly value="{{ $item->product->id }}" />
                            </div>
                        </div>
                    </td>
                    <td class="col-4"><input type="number" name="quantities[]" class="form-control" readonly value="{{ $item->qty }}" /></td>
                    <td class="col-4">
                        <select class="form-control" id="uom" name="uoms[]" disabled >
                            <option value="{{ $item->uom->id }}">{{ $item->uom->name }}</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @stop

    @section('footer')
    <div class="row">
        <div class="col-2">
            <a href="/sales-delivery-note"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>
    </div>
    </form>
@stop

