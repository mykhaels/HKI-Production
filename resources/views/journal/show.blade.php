@extends('adminlte::page')
@section('title', 'Detail Jurnal')

@section('content_header')
    <h1>Detail Jurnal</h1>
@stop

@section('content')
<form method="post" action="/journal">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Transaksi</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $journal->code }}"  placeholder="J00001" readonly>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ $journal->transaction_date }}" readonly>
            @error('transaction_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="button" class="btn btn-primary col-md-2 offset-md-5" id="add_row" float="right" disabled>
            Tambah data
        </button>
    </div>
    <table class="table" id="details_table">
        <thead>
            <tr>
                <th scope="col">Kode-Nama Akun</th>
                <th scope="col">D/K</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($journal->journalDetails as $item)
            <tr scope="row">
                <td >
                    <div class="form-row">
                        <div class="col">
                            <input type="input" name="codes[]" class="form-control"  readonly value="{{ $item->coa->code }}-{{ $item->coa->name }}"/>
                            <input type="hidden" name="coas[]" class="form-control"  readonly value="{{ $item->id }}"/>
                        </div>
                    </div>
                </td>
                <td>
                    <select class="form-control" id="account" name="accounts[]" readonly>
                        <option value="{{ $item->account }}">{{ $item->account }}</option>
                    </select>
                </td>
                <td><input type="number" name="totals[]" class="form-control"  value="{{ $item->total }}" readonly/></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('footer')
<div class="row">
    <div class="col-2">
        <a href="/journal"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
    <div class="col-10 text-right">
        <a class="btn btn-primary" href="/journal/{{ $journal->id }}/edit">Ubah</a>
    </div>
</div>
</form>
@stop
