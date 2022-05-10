@extends('adminlte::page')
@section('title', 'Detail Retur Penjualan')

@section('content_header')
    <h1>Detail Retur Penjualan</h1>
@stop


@section('content')
<form method="post" action="/retur-sales">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Retur</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control"  name="code" value="{{ $returSale->code }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Retur</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control" id="transaction_date"  name="transaction_date" value="{{ $returSale->transaction_date }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="customer" class="col-sm-2 col-form-label">Pelanggan</label>
        <div  class="col-sm-2">
            <select class="form-control" id="customer" name="customer_id" disabled>
                <option value="{{ $returSale->customer_id }}">{{ $returSale->customer->name }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="sj" class="col-sm-2 col-form-label">Kode SJ</label>
        <div  class="col-sm-2">
            <select class="form-control" id="sj" name="sales-delivery-note_id" disabled>
                <option value="{{ $returSale->salesDeliveryNote->id }}">{{ $returSale->salesDeliveryNote->code }}</option>
            </select>
        </div>
    </div>
    <div class="table-responsive-md">
        <table class="table" id="details_table">
            <thead>
                <tr scope="row" class="d-flex">
                    <th scope="col" class="col-4">Kode-Nama Produk</th>
                    <th scope="col" class="col-4">Qty</th>
                    <th scope="col" class="col-4">Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($returSale->returSalesDetails as $item)
                <tr scope="row" class="d-flex">
                    <td class="col-4">
                        <div class="form-row">
                            <div class="col">
                                <input type="input" name="codes[]" class="form-control"   disabled value="{{ $item->product->code }}-{{ $item->product->name }}"/>
                                <input type="hidden" name="products[]" class="form-control"  disabled value="{{ $item->product->id }}" />
                            </div>
                        </div>
                    </td>
                    <td class="col-4"><input type="number" name="quantities[]" class="form-control" disabled value="{{ $item->qty }}" /></td>
                    <td class="col-4">
                        <select class="form-control" id="uom" name="uoms[]" disabled >
                            <option value="{{ $item->uom->id }}">{{ $item->uom->name }}</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-labelledby="modalTableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalHeader">Jurnal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <table id="modal_table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="display: none">ID</th>
                            <th scope="col">Kode</th>
                            <th scope="col">D/K</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($journal->journalDetails as $item)
                            <tr>
                                <td style='display:none'>{{ $item->id }}</td>
                                <td>{{ $item->coa->code }}-{{ $item->coa->name }}</td>
                                <td>{{ $item->account }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

    @stop

    @section('footer')
    <div class="row">
        <div class="col-2">
            <a href="/retur-sales"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>
        <div class="col-10 text-right">
            <button type="button" class="btn btn-primary open-modal" onclick="openModel()">Lihat Jurnal</button>
        </div>
    </div>
    </form>
@stop

@section('js')
<script>
    function openModel(){
        $('#modalTable').modal('show');
    }
</script>
@stop

