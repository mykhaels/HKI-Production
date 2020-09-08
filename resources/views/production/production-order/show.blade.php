@extends('adminlte::page')
@section('title', 'Detail Perintah Produksi')

@section('content_header')
    <h1>DETAIL PERINTAH PRODUKSI</h1>
@stop

@section('content')
<form method="post" action="/production-order">
    @csrf
    <div class="form-group row">
        <label for="productType" class="col-sm-2 col-form-label">Tipe Produk</label>
        <div  class="col-sm-2">
            <select class="form-control" id="productType" name="production_type" disabled>
                <option value="1" @if ($productionOrder->production_type == 1)
                    selected
                @endif>Barang Jadi</option>
                <option value="2" @if ($productionOrder->production_type == 2)
                    selected
                @endif>Bahan Baku</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">No Perintah</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $productionOrder->code }}" disabled>
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Perintah</label>
        <div  class="col-sm-2">
        <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ $productionOrder->transaction_date }}" disabled>
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
                <th scope="col">Kode-Nama Bahan</th>
                <th scope="col">Qty</th>
                <th scope="col">Satuan</th>
                <th scope="col">Hapus</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productionOrder->productionOrderDetails as $item)
                <tr scope="row">
                    <td >
                        <div class="form-row">
                            <div class="col">
                                <input type="input" name="codes[]" value="{{ $item->product->code }}-{{ $item->product->name }}" class="form-control"  readonly />
                                <input type="hidden" name="products[]" class="form-control"  value="{{ $item->product_id }}" readonly />
                            </div>
                            <div class="col col-sm-2">
                                <button type="button" class="btn btn-primary form-control open-modal" onclick="openModel(this)" disabled>Src</button>
                            </div>
                        </div>
                    </td>
                    <td><input type="number" name="quantities[]" value="{{ $item->qty }}" class="form-control"  disabled/></td>
                    <td>
                        <select class="form-control" id="uom" name="uoms[]" disabled>
                            <option value="{{ $item->uom_id }}">{{ $item->uom->name }}</option>
                        </select>
                    </td>
                    <td><button class="btn btn-danger" onclick="deleteRow(this)" disabled>Hapus</button></td>
                </tr>

            @endforeach
        </tbody>
    </table>



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
        <a href="/production-order"><button type="button" class="btn btn-primary">Kembali</button></a>
    </div>
    {{-- <div class="col-10 text-right">
        <button type="submit" class="btn btn-primary">Simpan</a>
    </div> --}}
</div>
</form>
@stop

@section('js')
<script>
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    var selectedRow = null;
    var selectedModelRow = null;
    var selectedUoms = null;

    let row =  '<tr scope="row">'
                +'<td >'
                    +'<div class="form-row">'
                        +'<div class="col">'
                            +'<input type="input" name="codes[]" class="form-control"  readonly />'
                            +'<input type="hidden" name="products[]" class="form-control"  readonly />'
                        +'</div>'
                        +'<div class="col col-sm-2">'
                            +'<button type="button" class="btn btn-primary form-control open-modal" data-toggle="modal" onclick="openModel(this)">Src</button>'
                        +'</div>'
                    +'</div>'
                +'</td>'
                +'<td><input type="number" name="quantities[]" class="form-control" value="1" /></td>'
                +'<td>'
                    +'<select class="form-control" id="uom" name="uoms[]">'

                    +'</select>'
                +'</td>'
                +'<td><button class="btn btn-danger" onclick="deleteRow(this)">Hapus</button></td>'
            +'</tr>';

    let row_number = 1;
    $("#add_row").click(function(e){
        e.preventDefault();
        $('#details_table').append(row);
    });


    function deleteRow(e){
        $(e).parent().parent().remove();
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
        }

    }

    function lookUpProductModel(value){
        var type = $('#productType').val();
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


</script>
@stop
