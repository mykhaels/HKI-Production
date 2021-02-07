@extends('adminlte::page')
@section('title', 'Insert Penghapusan Pembelian')

@section('content_header')
    <h1>Insert Penghapusan Pembelian</h1>
@stop

@section('css')
<style>
    input[type=checkbox]
    {
    /* Double-sized Checkboxes */
    -ms-transform: scale(2); /* IE */
    -moz-transform: scale(2); /* FF */
    -webkit-transform: scale(2); /* Safari and Chrome */
    -o-transform: scale(2); /* Opera */
    padding: 10px;
    }
</style>
@Stop

@section('content')
<form method="post" action="/writeoff">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Penghapusan</label>
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
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Penghapusan</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ old('transaction_date') }}">
            @error('transaction_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
        <div  class="col-sm-2">
            <select class="form-control  @error('supplier_id') is-invalid @enderror" id="supplier" name="supplier_id">
                <option value="0">--Pilih--</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
            @error('supplier_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    @error('checks')
    <div class="invalid-feedback d-flex">
        {{ $message }}
    </div>
    @enderror
    <div class="table-responsive-md">
        <table class="table" id="details_table">
            <thead>
                <tr scope="row" class="d-flex">
                    <th scope="col" class="col-1"></th>
                    <th scope="col" class="col-6">Kode Faktur</th>
                    <th scope="col" class="col-5">Nilai Faktur</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="form-group d-flex justify-content-end">
        <label for="total-invoice" class="col-md-2 m-1">Nilai Total</label>
        <input type="input" class="form-control col-md-2" id="total-invoice" name="total-invoice" readonly value="0">
    </div>
    <div class="form-group d-flex justify-content-end">
        <label for="total-writeoff" class="col-md-2 m-1">Nilai Penghapusan</label>
        <input type="input" class="form-control col-md-2 @error('total') is-invalid @enderror" id="total-writeoff" readonly name="total" value="0">
    </div>
    @error('total')
        <div class="invalid-feedback d-flex justify-content-end">
            {{ $message }}
        </div>
    @enderror

    @stop

    @section('footer')
    <div class="row">
        <div class="col-2">
            <a href="/writeoff"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>
        <div class="col-10 text-right">
            <button type="submit" class="btn btn-primary">Simpan</a>
        </div>
    </div>
    </form>
@stop

@section('js')
<script>
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

    $('#supplier').change(function(){
        $('#total-invoice').val(0);
        $('#total-writeoff').val(0);
        $('#details_table tbody').empty();
        if($(this).val()!=0){
            $.ajax({
                method : "GET",
                url : "{{ url('/settlement/getNotSettledInvoice')}}",
                data:{'id':$(this).val()},
                success:function(response){
                    $.each(response, function(index,invoice){
                        let remainder = parseInt(invoice.total)-parseInt(invoice.settlement_total);
                        let row =  '<tr scope="row" class="d-flex">'
                            +'<td scope="col" class="col-1 text-center"><input type="checkbox" name="checks[]" class="form-check-input" style="margin-top:0.7rem; margin-left:0.5rem;" onchange="calculateTotal()" /></td>'
                            +'<td scope="col"  class="col-6">'
                                +'<div class="row">'
                                    +'<div class="col">'
                                        +'<input type="input" name="codes[]" class="form-control"  readonly value="'+invoice.code+'"/>'
                                        +'<input type="hidden" name="invoices[]" style="display:none" readonly value="'+invoice.id+'"/>'
                                    +'</div>'
                                +'</div>'
                            +'</td>'
                            +'<td scope="col" class="col-5">'
                            +'<input type="number" name="remainders[]" class="form-control " value="'+remainder+'" readonly/>'
                            +'<input type="hidden" name="totals[]" class="form-control " value="'+invoice.total+'"/>'
                            +'</td>'
                        +'</tr>';
                        $('#details_table tbody').append(row);
                    });
                }
            });
        }
    });

    function calculateTotal(){
        $('#total-invoice').val(0);
        $('#total-writeoff').val(0);
        let total = 0;
        $('input[name^="checks"]:checked').each(function(index,value) {
            let remainders=$($('input[name="remainders[]"]').get(index)).val();
            total +=parseInt(remainders);
        });
        $('#total-invoice').val(total);
        $('#total-writeoff').val(total);
    }

</script>
@stop

