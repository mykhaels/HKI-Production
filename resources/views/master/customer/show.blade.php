@extends('adminlte::page')
@section('title', 'Detail Pelanggan')

@section('content_header')
    <h1>Detail Pelanggan</h1>
@stop

@section('content')
<form method="post" action="/customer">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Pelanggan</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $customer->code }}" disabled>

        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label" >Nama Pelanggan</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"  name="name" value="{{ $customer->name }}" disabled >

        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Alamat Pelanggan</label>
        <div  class="col-sm-2">
        <textarea class="form-control @error('address') is-invalid @enderror" id="address"  name="address"  disabled rows="5">{{ $customer->address }}</textarea>

        </div>
    </div>
    <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">No. Telepon</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"  name="phone" value="{{ $customer->phone }}" disabled >

        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div  class="col-sm-2">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"  name="email" value="{{ $customer->email }}" disabled >

        </div>
    </div>
    <div class="form-group row">
        <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp"  name="npwp" value="{{ $customer->npwp }}" disabled >

        </div>
    </div>

@stop

@section('footer')

<div class="row">
    <div class="col-2">
        <a href="/customer"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
</div>
</form>

@stop
