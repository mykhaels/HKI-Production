@extends('adminlte::page')
@section('title', 'Detail Faktur Pembelian')

@section('content_header')
    <h1>Detail Faktur Penjualan</h1>
@stop

@section('content')
<form method="post" action="/sales-invoice">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Faktur</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control" id="code"  name="code" value="{{ $salesInvoice->code }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Faktur</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control " id="transaction_date"  name="transaction_date" value="{{ $salesInvoice->transaction_date }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="customer" class="col-sm-2 col-form-label">Pelanggan</label>
        <div  class="col-sm-2">
            <select class="form-control" id="customer" name="customer_id" disabled>
                <option value="{{ $salesInvoice->customer_id }}">{{ $salesInvoice->customer->name }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="sj" class="col-sm-2 col-form-label">Kode SJ</label>
        <div  class="col-sm-2">
            <select class="form-control" id="sj" name="sales_delivery_note_id" disabled>
                <option value="{{ $salesInvoice->salesDeliveryNote->id }}">{{ $salesInvoice->salesDeliveryNote->code }}</option>
            </select>
        </div>
    </div>


    <div class="table-responsive-md">
    <table class="table" id="details_table">
        <thead>
            <tr scope="row" class="d-flex">
                <th scope="col" class="col-3">Kode-Nama Produk</th>
                <th scope="col" class="col-1">Qty</th>
                <th scope="col" class="col-2">Satuan</th>
                <th scope="col" class="col-2">Harga</th>
                <th scope="col" class="col-1">Diskon</th>
                <th scope="col" class="col-1">Status Pajak</th>
                <th scope="col" class="col-2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesInvoice->salesInvoiceDetails as $item)
            <tr scope="row" class="d-flex">
                <td class="col-3">
                    <div class="form-row">
                        <div class="col">
                            <input type="input" name="codes[]" class="form-control"  readonly readonly value="{{ $item->product->code }}-{{ $item->product->name }}"/>
                            <input type="hidden" name="products[]" class="form-control"  readonly value="{{ $item->product->id }}" />
                        </div>
                    </div>
                </td>
                <td class="col-1"><input type="number" name="quantities[]" class="form-control" readonly value="{{ $item->qty }}" /></td>
                <td class="col-2">
                    <select class="form-control" id="uom" name="uoms[]" readonly >
                        <option value="{{ $item->uom->id }}">{{ $item->uom->name }}</option>
                    </select>
                </td>
                <td class="col-2"><input type="number" name="prices[]" class="form-control" readonly value="{{ $item->price }}" /></td>
                <td class="col-1"><input type="number" name="discounts[]" class="form-control" readonly value="{{ $item->discount }}"/></td>
                <td class="col-1">
                    <div>
                        <select class="form-control" id="tax" name="taxs[]" readonly>
                            <option value="1" @if ($item->tax_status == 1)
                                selected
                            @endif>Ya</option>
                            <option value="2" @if ($item->tax_status == 2)
                                selected
                            @endif>Tidak</option>
                        </select>
                    </div>
                </td>
                <td class="col-2"><input type="number" name="totals[]" class="form-control" readonly value="{{ $item->total }}"/></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="form-group d-flex justify-content-end">
    <label for="subtotal-input" class="col-md-1 m-1">Sub Total</label>
    <input type="input" class="form-control col-md-2" id="subtotal-input" name="subtotal" readonly value="{{ $salesInvoice->salesDeliveryNote->salesOrder->subtotal }}">
</div>
<div class="form-group d-flex justify-content-end">
    <label for="ppn-input" class="col-md-1 m-1">PPN</label>
    <input type="input" class="form-control col-md-2" id="ppn-input" name="ppn" readonly value="{{ $salesInvoice->salesDeliveryNote->salesOrder->ppn }}">
</div>
<div class="form-group d-flex justify-content-end">
    <label for="dp-input" class="col-md-1 m-1">DP</label>
    <input type="input" class="form-control col-md-2" id="dp-input" name="dp" readonly value="{{ $salesInvoice->salesDeliveryNote->salesOrder->initialPaymentSales!=null ? $salesInvoice->salesDeliveryNote->salesOrder->initialPaymentSales->dp :0 }}">
</div>
<div class="form-group d-flex justify-content-end">
    <label for="total-input" class="col-md-1 m-1">Total</label>
    <input type="input" class="form-control col-md-2" id="total-input" name="total" readonly value="{{ $salesInvoice->total }}">
</div>



@stop

@section('footer')
<div class="row">
    <div class="col-2">
        <a href="/sales-invoice"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
</div>
</form>
@stop

