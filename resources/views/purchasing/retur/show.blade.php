@extends('adminlte::page')
@section('title', 'Detail Retur Pembelian')

@section('content_header')
    <h1>Detail Retur Pembelian</h1>
@stop


@section('content')
<form method="post" action="/retur">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Retur</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control"  name="code" value="{{ $retur->code }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Retur</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control" id="transaction_date"  name="transaction_date" value="{{ $retur->transaction_date }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
        <div  class="col-sm-2">
            <select class="form-control" id="supplier" name="supplier_id" disabled>
                <option value="{{ $retur->supplier_id }}">{{ $retur->supplier->name }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="bpb" class="col-sm-2 col-form-label">Kode BPB</label>
        <div  class="col-sm-2">
            <select class="form-control" id="bpb" name="good_receipt_id" disabled>
                <option value="{{ $retur->goodReceipt->id }}">{{ $retur->goodReceipt->code }}</option>
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
                @foreach ($retur->returDetails as $item)
                <tr scope="row" class="d-flex">
                    <td class="col-4">
                        <div class="form-row">
                            <div class="col">
                                <input type="input" name="codes[]" class="form-control"   disabled value="{{ $item->product->code }}-{{ $item->product->name }}"/>
                                <input type="hidden" name="products[]" class="form-control"  disabled value="{{ $item->product->id }}" />
                            </div>
                        </div>
                    </td>
                    <td class="col-4"><input type="number" name="quantities[]" class="form-control" disabled value="{{ $item->qty }}" /></td>
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
            <a href="/retur"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>
    </div>
    </form>
@stop

