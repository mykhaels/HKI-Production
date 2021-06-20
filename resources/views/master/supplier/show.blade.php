@extends('adminlte::page')
@section('title', 'Detail Supplier')

@section('content_header')
    <h1>Detail Supplier</h1>
@stop

@section('content')
<form method="post" action="/supplier">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Supplier</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $supplier->code }}" disabled>

        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label" >Nama Supplier</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"  name="name" value="{{ $supplier->name }}" disabled >

        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Alamat Supplier</label>
        <div  class="col-sm-2">
        <textarea class="form-control @error('address') is-invalid @enderror" id="address"  name="address"  disabled rows="5">{{ $supplier->address }}</textarea>

        </div>
    </div>
    <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">No. Telepon</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"  name="phone" value="{{ $supplier->phone }}" disabled >

        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div  class="col-sm-2">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"  name="email" value="{{ $supplier->email }}" disabled >

        </div>
    </div>
    <div class="form-group row">
        <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp"  name="npwp" value="{{ $supplier->npwp }}" disabled >

        </div>
    </div>

@stop

@section('footer')

<div class="row">
    <div class="col-2">
        <a href="/supplier"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
</div>
</form>

@stop
