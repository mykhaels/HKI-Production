@extends('adminlte::page')
@section('title', 'Edit Jurnal')

@section('content_header')
    <h1>EDIT JURNAL</h1>
@stop

@section('content')
<form method="post" action="/journal/{{ $journal->id }}">
    @method("patch")
    @csrf
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">Kode Transaksi</label>
        <div  class="col-sm-2">
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"  name="code" value="{{ $journal->code }}"  placeholder="J00001">
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
        <div  class="col-sm-2">
            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"  name="transaction_date" value="{{ $journal->transaction_date }}">
            @error('transaction_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="button" class="btn btn-primary col-md-2 offset-md-5" id="add_row" float="right">
            Tambah data
        </button>
    </div>
    <table class="table" id="details_table">
        <thead>
            <tr>
                <th scope="col">Kode-Nama Akun</th>
                <th scope="col">D/K</th>
                <th scope="col">Total</th>
                <th scope="col">Hapus</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($journal->journalDetails as $item)
            <tr scope="row">
                <td >
                    <div class="form-row">
                        <div class="col">
                            <input type="input" name="codes[]" class="form-control"  readonly value="{{ $item->coa->code }}-{{ $item->coa->name }}"/>
                            <input type="hidden" name="coas[]" class="form-control"  readonly value="{{ $item->coa_id }}"/>
                        </div>
                        <div class="col col-sm-2">
                            <button type="button" class="btn btn-primary form-control open-modal" onclick="openModel(this)">Src</button>
                        </div>
                    </div>
                </td>
                <td>
                    <select class="form-control" id="account" name="accounts[]">
                        <option value="Debit"
                            @if($item->account=="Debit")
                                selected
                            @endif>Debit</option>
                        <option value="Kredit"
                            @if($item->account=="Kredit")
                                selected
                            @endif>Kredit</option>
                    </select>
                </td>
                <td><input type="number" name="totals[]" class="form-control" value="{{ $item->total }}" /></td>
                <td><button class="btn btn-danger" onclick="deleteRow(this)">Hapus</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>



<!-- Modal -->
<div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-labelledby="modalTableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Find Account</h5>
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
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveAccount()">Save changes</button>
        </div>
      </div>
    </div>
  </div>

@stop

@section('footer')
<div class="row">
    <div class="col-2">
        <a href="/journal"><button type="button" class="btn btn-primary">Kembali</button></a>
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

    let row =  '<tr scope="row">'
                +'<td >'
                    +'<div class="form-row">'
                        +'<div class="col">'
                            +'<input type="input" name="codes[]" class="form-control"  readonly />'
                            +'<input type="hidden" name="coas[]" class="form-control"  readonly />'
                        +'</div>'
                        +'<div class="col col-sm-2">'
                            +'<button type="button" class="btn btn-primary form-control open-modal" data-toggle="modal" onclick="openModel(this)">Src</button>'
                        +'</div>'
                    +'</div>'
                +'</td>'
                +'<td>'
                    +'<select class="form-control" id="account" name="accounts[]">'
                        +'<option value="Debit">Debit</option>'
                        +'<option value="Kredit">Kredit</option>'
                    +'</select>'
                +'</td>'
                +'<td><input type="number" name="totals[]" class="form-control" value="0" /></td>'
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
        lookUpAccountModel(value);
    });

    function highlightRow(e){
        $(e).addClass('bg-primary').siblings().removeClass('bg-primary');
        selectedModelRow=$(e);

    }

    function openModel(e){
        $('#search').val("");
        if(selectedModelRow!=null){
            $(selectedModelRow).removeClass('bg-primary');
            selectedModelRow=null;
        }
        selectedRow = $(e).parent().siblings().children();
        selectedUoms = $(e).parent().parent().parent().siblings(1).children()[1];
        $('#modalTable').modal('show');
    }

    function saveAccount(){
        if(selectedModelRow!=null){
            $(selectedRow[0]).val(selectedModelRow.find('td:nth-child(2)').html()+"-"+selectedModelRow.find('td:nth-child(3)').html());
            $(selectedRow[1]).val(selectedModelRow.find('td:first').html());
            $(selectedUoms).empty();
            $(selectedUoms).append(selectedModelRow.find('td:nth-child(4)').html());
        }

    }

    function lookUpAccountModel(value){
        $.ajax({
            method : "GET",
            url : "{{ url('/journal/search_account')}}",
            data:{'search':value},
            success:function(response){
                $('#modal_table > tbody').html("");
                $.each(response, function(i, item) {
                    //Looping each Account and show in modal
                    var newRowContent = "<tr onclick='highlightRow(this)'>"+
                    "<td style='display:none'>"+item.id+"</td><td>"+item.code+"</td><td>"+item.name+"</td>"+

                    "</tr>";
                    $('#modal_table').append(newRowContent);
                });
            }
        });
    }


</script>
@stop
