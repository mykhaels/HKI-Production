@extends('adminlte::page')
@section('title', 'Detail Penerimaan Pembelian')

@section('content_header')
    <h1>Detail Penerimaan Pembelian</h1>
@stop


@section('content')
<form method="post" action="/good-receipt">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode BPB</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control"  name="code" value="{{ $goodReceipt->code }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal BPB</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control" id="transaction_date"  name="transaction_date" value="{{ $goodReceipt->transaction_date }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
        <div  class="col-sm-2">
            <select class="form-control" id="supplier" name="supplier_id" disabled>
                <option value="{{ $goodReceipt->supplier_id }}">{{ $goodReceipt->supplier->name }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="po" class="col-sm-2 col-form-label">Kode PO</label>
        <div  class="col-sm-2">
            <select class="form-control" id="po" name="purchase_order_id" disabled>
                <option value="{{ $goodReceipt->purchaseOrder->id }}">{{ $goodReceipt->purchaseOrder->code }}</option>
            </select>
        </div>
    </div>
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
                @foreach ($goodReceipt->goodReceiptDetails as $item)
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
                        <select class="form-control" id="uom" name="uoms[]" readonly >
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
            <a href="/good-receipt"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>
    </div>
    </form>
@stop

