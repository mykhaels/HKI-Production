@extends('adminlte::page')
@section('title', 'Insert Supplier')

@section('content_header')
    <h1>INSERT SUPPLIER</h1>
@stop

@section('content')
<form method="post" action="/supplier">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Supplier<span style="color:red;">*</span></label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $generatedCode }}" readonly>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label" >Nama Supplier<span style="color:red;">*</span></label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"  name="name" value="{{ old('name') }}" >
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Alamat Supplier<span style="color:red;">*</span></label>
        <div  class="col-sm-2">
            <textarea class="form-control @error('address') is-invalid @enderror" id="address"  name="address" value="{{ old('address') }}" rows="5"></textarea>
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">No. Telepon<span style="color:red;">*</span></label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"  name="phone" value="{{ old('phone') }}" >
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email<span style="color:red;">*</span></label>
        <div  class="col-sm-2">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"  name="email" value="{{ old('email') }}" >
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp"  name="npwp" value="{{ old('npwp') }}" >
            @error('npwp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

@stop

@section('footer')

<div class="row">
    <div class="col-2">
        <a href="/supplier"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
    <div class="col-10 text-right">
        <button type="submit" class="btn btn-primary">Simpan</a>
    </div>
</div>
</form>

@stop
