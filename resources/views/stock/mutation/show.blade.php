@extends('adminlte::page')
@section('title', 'Detail Penerimaan Barang')

@section('content_header')
    <h1>Detail Penerimaan Barang</h1>
@stop

@section('content')
<form method="post" action="/transfer-in">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">No Penerimaan</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $transferIn->code }}" disabled>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Penerimaan</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ $transferIn->transaction_date }}" disabled>
            @error('transaction_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="customer" class="col-sm-2 col-form-label">No Ref Kode Permintaan</label>
        <div  class="col-sm-2">
            <select class="form-control  @error('transfer_request_id') is-invalid @enderror" id="transfer_request_id" name="transfer_request_id" disabled>
            <option value="0">--Pilih--</option>
                <option value="{{ $transferIn->transferRequest->id }}" selected>{{ $transferIn->transferRequest->code }}</option>
            </select>
            @error('transfer_request_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Ref Tanggal Permintaan</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control" id="transfer_request_date" value="{{ $transferIn->transferRequest->transaction_date }}"  name="transfer_request_date" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            @if ($transferIn->transferRequest->product_type==1)
                <input class="form-control" id="productType" value="Barang Jadi" disabled/>
            @elseif ($transferIn->transferRequest->product_type==12)
                <input class="form-control" id="productType" value="Bahan Baku" disabled/>
            @else
                <input class="form-control" id="productType" value="Pendukung" disabled/>
            @endif

        </div>
    </div>
    </div>
    <table class="table" id="details_table">
        <thead>
            <tr>
                <th scope="col">Kode-Nama Produk</th>
                <th scope="col">Qty</th>
                <th scope="col">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transferIn->transferInDetails as $item)
            <tr scope="row">
                <td scope="col">
                    <div class="row">
                        <div class="col">
                            <input type="input" name="codes[]" class="form-control"  readonly value="{{ $item->product->code }}-{{ $item->product->name }}"/>
                            <input type="hidden" name="products[]" style="display:none" readonly value="{{ $item->product->id }}"/>
                        </div>
                    </div>
                </td>
                <td scope="col"><input type="number" name="quantities[]" class="form-control" value="{{ $item->qty }}" readonly /></td>
                <td scope="col">
                    <select class="form-control" id="uom" name="uoms[]" readonly>
                        <option value="{{ $item->uom->id }}">{{ $item->uom->name }}</option>
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
        <a href="/transfer-in"><button type="button" class="btn btn-primary">Kembali</button></a>
      </div>
      <div class="col-10 text-right">
          <button type="submit" class="btn btn-primary">Simpan</a>
      </div>
  </div>
  </form>
  @stop


