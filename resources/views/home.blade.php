@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>DashBoard</h1>
@stop

@section('content')
    <!-- Chart's container -->
    <div class="row">
        <div class="card col-6">
            <div class="card-header">
              Perintah Produksi
            </div>
            <div class="card-body">
                <div id="chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}
@section('plugins.Chartjs', true)
@section('js')
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('ProductionOrderChart')",
            hooks: new ChartisanHooks()
                .colors(['#ECC94B', '#4299E1','#FACF5A'])
                .legend({ position: 'bottom' })
                .datasets([{ type: 'bar', fill: false }, 'bar']),

        });
    </script>
@stop
