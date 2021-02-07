<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permintaan Pengiriman Produksi</title>
</head>

<body>
    <div id="header">
        <div id="detail">

            <img src="{{ asset('/vendor/adminlte/dist/img/clien_logo.png') }}" width="300" height="300"/>
        </div>
        <div>
            <h2>Permintaan Pengiriman Produksi</h2>
        </div>
        <div id="logo">
        </div>
    </div>
    <div id="body">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th>#</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @php($counter=1)
                @foreach($deliveryRequest->deliveryRequestDetails ?? '' as $item)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $item->product->code }}</td>
                    <td>{{ $item->qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="footer">

    </div>

</body>

</html>
