<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ProductionOrderChart extends BaseChart
{
     /**
     * Determines the chart name to be used on the
     * route. If null, the name will be a snake_case
     * version of the class name.
     */
    public ?string $name = 'Chart Perintah Produksi';

    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directrive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'ProductionOrderChart';

    /**
     * Determines the prefix that will be used by the chart
     * endpoint.
     */
    // public ?string $prefix = 'some_prefix';

    /**
     * Determines the middlewares that will be applied
     * to the chart endpoint.
     */
    // public ?array $middlewares = ['auth'];

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {

        $data = DB::table('production_orders')->selectRaw('count(id) AS count, status')->groupBy('status')->get();
        $array = [0,0,0];
        foreach($data as $d){
            if($d->status==1)$array[0]=$d->count;
            else if($d->status==2)$array[1]=$d->count;
            else $array[2]=$d->count;
        }
        return Chartisan::build()
            ->labels(['Baru', 'Terkirim', 'Selesai'])
            ->dataset('Perintah Produksi', $array);
    }
}
