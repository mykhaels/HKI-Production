@extends('adminlte::page')
@section('title', 'Akun')

@section('content_header')
    <h1>Master Akun</h1>
    <form method="post" action="/account">
        @csrf
        <div class="form-group row col-md-6">
          <label for="headAccount" class="col-sm-2 col-form-label">Akun Induk</label>
          <div class="col-sm-6  ">
            <select name="headAccount" id="headAccount" class="form-control">
                <option value="0">--Pilih--</option>
                @foreach ($headAccounts as $headAccount)
                    <option value="{{ $headAccount->code }}">{{ $headAccount->code }} - {{ $headAccount->name }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row col-md-6">
          <label for="code" class="col-sm-2 col-form-label">Kode Akun</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="code" name="code" placeholder="Kode Akun">
          </div>
        </div>
        <div class="form-group row col-md-6">
            <label for="code" class="col-sm-2 col-form-label">Nama Akun</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="name" name="name" placeholder="Nama Akun">
            </div>
        </div>
        <div class="form-group row col-md-6">
            <label class="col-sm-2 col-form-label">Tipe Akun</label>
            <div class="col-sm-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="accountType" value="Neraca" name="accountType[]">
                <label class="form-check-label" for="accountType">
                  Neraca
                </label>
              </div>
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="accountType" value="Laba Rugi" name="accountType[]">
                  <label class="form-check-label" for="accountType">
                    Laba Rugi
                  </label>
                </div>
            </div>
          </div>
        <div class="form-group row col-md-6">
          <label class="col-sm-2 col-form-label">Akun Type</label>
          <div class="col-sm-6">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="accountNormal" value="Debit" name="accountNormal[]">
              <label class="form-check-label" for="accountNormal">
                Debit
              </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="accountNormal" value="Kredit" name="accountNormal[]">
                <label class="form-check-label" for="accountNormal">
                  Kredit
                </label>
              </div>
          </div>
        </div>
        <div class="form-group row text-right">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Cari</button>
          </div>
        </div>
      </form>

@stop
@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/custom.css">
@stop

@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<table id="account-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead>
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >#</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Kode Akun</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Nama Akun</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Normal</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Tipe Akun</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Kode Akun Induk</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Tingkat</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Status</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="account-table" rowspan="1" colspan="1" >Aktivasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($accounts as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->account_normal }}</td>
                <td>{{ $item->account_type }}</td>
                <td>{{ $item->parent_code }}</td>
                <td>{{ $item->level }}</td>
                @if ($item->status==1)
                    <td>Aktif</td>
                @else
                    <td>Tidak Aktif</td>
                @endif
                <td>
                    <form action="account/status/{{ $item->id }}" method="post">
                        @method('patch')
                        @csrf
                        <button type="submit" class="btn btn-success">Ubah Status</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $accounts->links() }}
    </div>
 </div>
@stop
@section('footer')
@stop
