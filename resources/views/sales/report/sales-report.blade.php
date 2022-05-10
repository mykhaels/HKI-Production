@extends('adminlte::page')
@section('title', 'Laporan Penjualan')

@section('content_header')
    <h1>Laporan Penjualan</h1>
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

<form method="get" action="/report/sales-report/search">
    @csrf
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Penjualan</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control  @error('transaction_date_start') is-invalid @enderror" id="startDate"  name="transaction_date_start" value="{{ old('transaction_date_start') }}">
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
            <input type="date" class="form-control @error('transaction_date_end') is-invalid @enderror"  id="endDate" name="transaction_date_end" value="{{ old('transaction_date_end') }}">
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
            <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Kode Faktur</th>
            <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Nilai Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @if (session('reportSales'))
            {{ $reportSales = session('reportSales') }}
            @foreach ($reportSales as $item)
                <tr>
                    <td>{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                    <td>{{ $item->customer->code }} - {{ $item->customer->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>
<div class="row">
    <div class="col-12 pagination">
        {{ $reportSales->links() }}
    </div>
 </div>
@stop

@section('footer')
<div class="row">
    <div class="col-11 text-right">

        <button type="button" id="print" class="btn btn-primary">Export PDF</button></a>
    </div>
    <div class="col-1 text-right">
        <button type="submit" class="btn btn-primary">Tampilkan</a>
    </div>
</div>
</form>
@stop


@section('js')
<script>
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });


    $('#print').click(function(){
        console.log("abc");
            $.ajax({
                method : "GET",
                url : "{{ url('/report/pdf') }}",
                data:{'startDate':$('#startDate').val() , 'endDate':$('#endDate').val()},
                xhrFields: { responseType: 'blob'},
                success: function(response){
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "LaporanPenjualan.pdf";
                    link.click();
                },
                error: function(blob){
                    console.log(blob);
                }
            });
    });

</script>
@stop
