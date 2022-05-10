@extends('adminlte::page')
@section('title', 'Insert Pesanan Penjualan')

@section('content_header')
    <h1>Insert Pesanan Penjualan</h1>
@stop

@section('content')
<form method="post" action="/sales-order">
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode SO</label>
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
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal PO</label>
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
        <label for="customer" class="col-sm-2 col-form-label">Pelanggan</label>
        <div  class="col-sm-2">
            <select class="form-control  @error('customer_id') is-invalid @enderror" id="customer" name="customer_id">
            <option value="0">--Pilih--</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
            </select>
            @error('customer_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>
        <button type="button" class="btn btn-primary col-md-2 offset-md-5" id="add_row" float="right">
            Tambah data
        </button>
    </div>

    <div class="table-responsive-md">
    <table class="table" id="details_table" style="overflow: auto;">
        <thead>
            <tr scope="row" class="d-flex">
                <th scope="col" class="col-3">Kode-Nama Produk</th>
                <th scope="col" class="col-1">Qty</th>
                <th scope="col" class="col-1">Satuan</th>
                <th scope="col" class="col-2">Harga</th>
                <th scope="col" class="col-1">Diskon</th>
                <th scope="col" class="col-1">Status Pajak</th>
                <th scope="col" class="col-2">Total</th>
                <th scope="col" class="col-1">Hapus</th>
            </tr>
        </thead>
        <tbody>
            <tr scope="row" class="d-flex">
                <td class="col-3">
                    <div class="form-row">
                        <div class="col">
                            <input type="input" name="codes[]" class="form-control"  readonly />
                            <input type="hidden" name="products[]" class="form-control"  readonly />
                        </div>
                        <div class="col col-sm-3">
                            <button type="button" class="btn btn-primary form-control open-modal" onclick="openModel(this)">Src</button>
                        </div>
                    </div>
                </td>
                <td class="col-1"><input type="number" id="qty" name="quantities[]" min="0" class="form-control" value="1" onkeyup="calculateTotal()" oninput="validity.valid||(value='0');"/></td>
                <td class="col-1">
                    <select class="form-control" id="uom" name="uoms[]" onChange="uomChange(this)">
                    @foreach ($uoms as $uom)
                        <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                    @endforeach
                    </select>
                </td>
                <td class="col-2"><input type="number" name="prices[]"  min="0" class="form-control" value="0" onkeyup="calculateTotal()" oninput="validity.valid||(value='0');"/></td>
                <td class="col-1"><input type="number" name="discounts[]" min="0" class="form-control" value="0" onkeyup="calculateTotal()" oninput="validity.valid||(value='0');"/></td>
                <td class="col-1">
                    <div>
                        <select class="form-control" id="tax" name="taxs[]" onChange="calculateTotal()">
                            <option value="1">Ya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                </td>
                <td class="col-2"><input type="number" name="totals[]" class="form-control" value="0" readonly/></td>
                <td class="col-1"><button class="btn btn-danger" onclick="deleteRow(this)">Hapus</button></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="form-group d-flex justify-content-end">
    <label for="subtotal-input" class="col-md-1 m-1">Sub Total</label>
    <input type="input" class="form-control col-md-2" id="subtotal-input" name="subtotal" value="0" readonly>
</div>
<div class="form-group d-flex justify-content-end">
    <label for="ppn-input" class="col-md-1 m-1">PPN</label>
    <input type="input" class="form-control col-md-2" id="ppn-input" name="ppn" value="0" readonly>
</div>
<div class="form-group d-flex justify-content-end">
    <label for="total-input" class="col-md-1 m-1">Total</label>
    <input type="input" class="form-control col-md-2" id="total-input" name="total" value="0" readonly>
</div>



<!-- Modal -->
<div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-labelledby="modalTableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Find Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="col">
                    <input type="input"  class="form-control" id="search"  />
                </div>
            </div>
            <table id="modal_table" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="display: none">ID</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveProduct()">Save changes</button>
        </div>
      </div>
    </div>
  </div>

@stop

@section('footer')
<div class="row">
    <div class="col-2">
        <a href="/sales-order"><button type="button" class="btn btn-primary">Kembali</button></a>
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
    var selectedRow = null;
    var selectedModelRow = null;
    var selectedUoms = null;

    let row =  '<tr scope="row" class="d-flex">'
                +'<td class="col-3">'
                    +'<div class="form-row">'
                        +'<div class="col">'
                            +'<input type="input" name="codes[]" class="form-control"  readonly />'
                            +'<input type="hidden" name="products[]" class="form-control"  readonly />'
                        +'</div>'
                        +'<div class="col col-sm-3">'
                            +'<button type="button" class="btn btn-primary form-control open-modal" data-toggle="modal" onclick="openModel(this)">Src</button>'
                        +'</div>'
                    +'</div>'
                +'</td>'
                +'<td class="col-1"><input type="number" name="quantities[]" min="0" class="form-control" value="1" onkeyup="calculateTotal()" oninput="validity.valid||(value=\'0\');"/></td>'
                +'<td class="col-1">'
                    +'<select class="form-control" id="uom" name="uoms[]" onChange="uomChange(this)">'
                    +'@foreach ($uoms as $uom)'
                        +'<option value="{{ $uom->id }}">{{ $uom->name }}</option>'
                    +'@endforeach'
                    +'</select>'
                +'</td>'
                +'<td class="col-2"><input type="number" name="prices[]" class="form-control" min="0" value="0" onkeyup="calculateTotal()" oninput="validity.valid||(value=\'0\');"/></td>'
                +'<td class="col-1"><input type="number" name="discounts[]" min="0" class="form-control" value="0" onkeyup="calculateTotal()" oninput="validity.valid||(value=\'0\');"/></td>'
                +'<td class="col-1">'
                +'    <div>'
                +'        <select class="form-control" id="tax" name="taxs[]" onChange="calculateTotal()">'
                +'        <option value="1">Ya</option>'
                +'        <option value="2">Tidak</option>'
                +'        </select>'
                +'    </div>'
                +'</td>'
                +'<td class="col-2"><input type="number" name="totals[]" class="form-control" value="0" readonly/></td>'
                +'<td class="col-1"><button class="btn btn-danger" onclick="deleteRow(this)">Hapus</button></td>'
            +'</tr>';

    let row_number = 1;
    $("#add_row").click(function(e){
        e.preventDefault();
        $('#details_table').append(row);
    });


    function deleteRow(e){
        $(e).parent().parent().remove();
        calculateTotal();
    }

    $('#search').keypress(function(e){
        if(e.which == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('#search').keyup(function(e){
        var value=$(this).val();
        lookUpProductModel(value);
    });

    function highlightRow(e){
        $(e).addClass('bg-primary').siblings().removeClass('bg-primary');
        selectedModelRow=$(e);

    }


    function openModel(e){
        $('#search').val("");
        lookUpProductModel("");
        if(selectedModelRow!=null){
            $(selectedModelRow).removeClass('bg-primary');
            selectedModelRow=null;
        }
        selectedRow = $(e).parent().siblings().children();
        selectedUoms = $(e).parent().parent().parent().siblings(1).children()[1];
        $('#modalTable').modal('show');
    }

    function saveProduct(){
        if(selectedModelRow!=null){
            $(selectedRow[0]).val(selectedModelRow.find('td:nth-child(2)').html()+"-"+selectedModelRow.find('td:nth-child(3)').html());
            $(selectedRow[1]).val(selectedModelRow.find('td:first').html());
            $(selectedUoms).empty();
            $(selectedUoms).append(selectedModelRow.find('td:nth-child(4)').html());
            // let priceRow = $(selectedUoms).parent().siblings(3).children()[2];
            // $.when(updatePrice($(selectedUoms).val(),$(selectedRow[1]).val(),priceRow)).done(function(){
            //     calculateTotal();
            // });
        }

    }

    function lookUpProductModel(value){
        var type = 1;
        $.ajax({
            method : "GET",
            url : "{{ url('/production-order/search_product')}}",
            data:{'search':value,'type':type},
            success:function(response){
                $('#modal_table > tbody').html("");
                $.each(response, function(i, item) {
                    //Setting UOM Option
                    var options = "";
                    $.each(item.uoms, function(index,value){
                           options+="<option value='"+value.id+"'>"+value.name+"</option>";
                    });

                    //Looping each product and show in modal
                    var newRowContent = "<tr onclick='highlightRow(this)'>"+
                    "<td style='display:none'>"+item.id+"</td><td>"+item.code+"</td><td>"+item.name+"</td>"+
                        "<td style='display:none;'>"+
                            options
                        "</td>"+
                    "</tr>";
                    $('#modal_table').append(newRowContent);
                });
            }
        });
    }

    function uomChange(e){
        let uomId = $(e).val();
        let productId = $($(e).parent().siblings(0).children()[0]).find('input[name="products[]"]').val();
        let priceRow = $(e).parent().siblings(3).children()[2];
        // $.when(updatePrice(uomId,productId,priceRow)).done(function(){
        //     calculateTotal();
        // });


    };

    function updatePrice(uomId, productId, priceElement){
        return $.ajax({
            method : "GET",
            url : "{{ url('sales-order/get-price') }}",
            data:{'uomId':uomId,'productId':productId},
            success:function(response){
                $(priceElement).val(response);
            }
        });
    }


    function calculateTotal(){
        let subtotal = 0;
        let ppn = 0;
        let total = 0;
        $.each($('select[name="taxs[]"]'), function( index, value ) {
            let qty=$($('input[name="quantities[]"]').get(index)).val();
            let price=$($('input[name="prices[]"]').get(index)).val();
            let discount=$($('input[name="discounts[]"]').get(index)).val();
            if(price=="") return;
            let totalPerItem = qty*price-discount;
            if(totalPerItem<0) {
                $($('input[name="discounts[]"]').get(index)).val("0");
                discount=0;
                totalPerItem=qty*price-discount;
            }
            let ppnPerItem = (qty*price-discount)*0.1;
            subtotal+=totalPerItem;
            if($(value).val()==1){
                $($('input[name="totals[]"]').get(index)).val((totalPerItem+ppnPerItem).toFixed(2));
                ppn+=ppnPerItem;
                total+=totalPerItem+ppnPerItem;
            }else{
                $($('input[name="totals[]"]').get(index)).val((totalPerItem).toFixed(2));
                total+=totalPerItem;
            }
        });
        $('#subtotal-input').val(subtotal);
        $('#ppn-input').val(ppn);
        $('#total-input').val(total);
    }

</script>
@stop
