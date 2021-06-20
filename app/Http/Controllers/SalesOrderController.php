<?php

namespace App\Http\Controllers;

use App\SalesOrder;
use App\Customer;
use App\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.sales-order.index',  ['salesOrders'=>SalesOrder::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = SalesOrder::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='SO-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $customers=Customer::all();
        $uoms =Uom::all();
        return view('sales.sales-order.create', compact('generatedCode','uoms','customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:100'],
            'transaction_date' => ['required'],
            'customer_id' => ['required','not_in:0'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'customer_id.not_in' => 'Pelanggan harus dipilih !',
        ]);

        $SalesOrder = SalesOrder::create($request->all());

        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        $prices = $request->input('prices', []);
        $discounts = $request->input('discounts', []);
        $taxs = $request->input('taxs', []);
        $totals = $request->input('totals', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $SalesOrder->salesOrderDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i],
                    'price'=>$prices[$i],
                    'discount'=>$discounts[$i],
                    'tax_status'=>$taxs[$i],
                    'total'=>$totals[$i]
                    ]);
            }
        }
        return redirect('/sales-order')->with('status','Data Penjualan Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesOrder  $SalesOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SalesOrder $salesOrder)
    {
        return view('sales.sales-order.show',compact('salesOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesOrder  $SalesOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesOrder $SalesOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesOrder  $SalesOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesOrder $SalesOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesOrder  $SalesOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesOrder $SalesOrder)
    {
        //
    }

    public function updateStatus(SalesOrder $salesOrder){
        SalesOrder::where('id',$salesOrder->id)->update(['status'=>2]);
        return redirect('/sales-order')->with('status','Sales Order Berhasil dibatalkan !');
    }



    public function getPrice(Request $request){
        $price = DB::table('product_uom')->where('product_id', $request->productId)->where('uom_id', $request->uomId)->pluck('price')->first();
        return $price;
    }
}
