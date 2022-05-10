@extends('adminlte::page')
@section('title', 'Laporan Pembayaran')

@section('content_header')
    <h1>Laporan Pembayaran</h1>
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

<form method="post" action="/report/payment-report">
    @csrf
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Pembayaran</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date_start') is-invalid @enderror"  name="transaction_date_start" value="{{ old('transaction_date_start') }}">
            @error('transaction_date_start')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div  class="col-sm-1 text-center p-1">
            s&d
        </div>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date_end') is-invalid @enderror"  name="transaction_date_end" value="{{ old('transaction_date_end') }}">
            @error('transaction_date_end')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
<table id="report-table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
    <thead >
        <tr>
            <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Tanggal</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Nama Pelanggan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Kode Pelunasan</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Nilai Pelunasan</th>
        </tr>
    </thead>
    <tbody>

            @foreach ($reportPayment as $item)
                <tr>
                    <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                    <td>{{ $item->customer->code }} - {{ $item->customer->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach

    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $reportPayment->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-12 text-right">
        <button type="submit" class="btn btn-primary">Tampilkan</a>
    </div>
</div>
</form>
@stop

