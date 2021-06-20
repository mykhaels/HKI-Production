@extends('adminlte::page')
@section('title', 'Detail Penghapusan Penjualan')

@section('content_header')
    <h1>Detail Penghapusan Penjualan</h1>
@stop


@section('content')
<form method="post" action="/writeoff">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Penghapusan</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control"  name="code" value="{{ $salesWriteoff->code }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Penghapusan</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control" id="transaction_date"  name="transaction_date" value="{{ $salesWriteoff->transaction_date }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="customer" class="col-sm-2 col-form-label">Pelanggan</label>
        <div  class="col-sm-2">
            <select class="form-control" id="customer" name="customer_id" disabled>
                <option value="{{ $salesWriteoff->customer->id }}">{{ $salesWriteoff->customer->name }}</option>
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
                @foreach ($salesWriteoff->salesWriteOffDetails as $item)
                <tr scope="row" class="d-flex">
                    <td class="col-6">
                        <div class="form-row">
                            <div class="col">
                                <input type="input" name="codes[]" class="form-control"  readonly readonly value="{{ $item->salesInvoice->code }}"/>
                            </div>
                        </div>
                    </td>
                    <td class="col-6"><input type="number" name="writeoffs[]" class="form-control" readonly value="{{ $item->write_off_total }}" /></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="form-group d-flex justify-content-end">
        <label for="total-invoice" class="col-md-2 m-2">Nilai Total</label>
        <input type="input" class="form-control col-md-2" id="total-invoice" name="total-invoice" readonly value="{{ $salesWriteoff->total }}">
    </div>
    <div class="form-group d-flex justify-content-end">
        <label for="total-writeoff" class="col-md-2 m-2">Nilai Penghapusan</label>
        <input type="input" class="form-control col-md-2" id="total-writeoff" name="total" readonly value="{{ $salesWriteoff->total }}">
    </div>

    @stop

    @section('footer')
    <div class="row">
        <div class="col-2">
            <a href="/sales-writeoff"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>
    </div>
    </form>
@stop

