@extends('adminlte::page')
@section('title', 'Detail Pelunasan Pembelian')

@section('content_header')
    <h1>Detail Pelunasan Pembelian</h1>
@stop


@section('content')
<form method="post" action="/settlement">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Pelunasan</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control"  name="code" value="{{ $settlement->code }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Pelunasan</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control" id="transaction_date"  name="transaction_date" value="{{ $settlement->transaction_date }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
        <div  class="col-sm-2">
            <select class="form-control" id="supplier" name="supplier_id" disabled>
                <option value="{{ $settlement->supplier_id }}">{{ $settlement->supplier->name }}</option>
            </select>
        </div>
    </div>
    <div class="table-responsive-md">
        <table class="table" id="details_table">
            <thead>
                <tr scope="row" class="d-flex">
                    <th scope="col" class="col-6">Kode Faktur</th>
                    <th scope="col" class="col-6">Nilai Faktur</th>
                </tr>
            </thead>
            <tbody>
                @php $totalValue = 0; @endphp
                @foreach ($settlement->settlementDetails as $item)
                @php $totalValue += $item->settlement_total; @endphp
                <tr scope="row" class="d-flex">
                    <td class="col-6">
                        <div class="form-row">
                            <div class="col">
                                <input type="input" name="codes[]" class="form-control"  readonly readonly value="{{ $item->invoice->code }}"/>
                            </div>
                        </div>
                    </td>
                    <td class="col-6"><input type="number" name="settlements[]" class="form-control" readonly value="{{ $item->settlement_total }}" /></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="form-group d-flex justify-content-end">
        <label for="total-invoice" class="col-md-2 m-2">Nilai Total</label>
        <input type="input" class="form-control col-md-2" id="total-invoice" name="total-invoice" readonly value="{{ $totalValue }}">
    </div>
    <div class="form-group d-flex justify-content-end">
        <label for="total-settlement" class="col-md-2 m-2">Nilai Pelunasan</label>
        <input type="input" class="form-control col-md-2" id="total-settlement" name="total" readonly value="{{ $settlement->total }}">
    </div>

    @stop

    @section('footer')
    <div class="row">
        <div class="col-2">
            <a href="/settlement"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>
    </div>
    </form>
@stop

