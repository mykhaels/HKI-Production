
<style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td, tr, thead, th {
      border: 1px solid #dddddd;
      text-align: center;
      padding: 8px;
    }

</style>
<h1 style="text-align: center">Laporan Penjualan</h1>
<div>
   <span>Period : {{ $startDate }} - {{ $endDate }}</span>
</div>
<br>
<table id="report-table"  role="grid">
        <thead >
            <tr>
                <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Tanggal</th>
                <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Nama Pelanggan</th>
                <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Kode Faktur</th>
                <th scope="col" class="sorting" tabindex="0" aria-controls="report-table" rowspan="1" colspan="1" >Nilai Penjualan</th>
            </tr>
        </thead>
        <tbody>
                @foreach ($reportSales as $item)
                    <tr>
                        <td >{{ date('d-M-Y', strtotime($item->transaction_date)) }}</td>
                        <td >{{ $item->customer->code }} - {{ $item->customer->name }}</td>
                        <td >{{ $item->code }}</td>
                        <td >{{ $item->total }}</td>
                    </tr>
                @endforeach

        </tbody>
</table>
