<?php

namespace App\Http\Controllers;

use App\InitialPaymentSales;
use App\SalesOrder;
use App\Customer;
use Illuminate\Http\Request;

class InitialPaymentSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.initial-payment-sales.index',  ['initialPaymentsSales'=>InitialPaymentSales::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = InitialPaymentSales::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='DP-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $customers=Customer::all();
        return view('sales.initial-payment-sales.create', compact('generatedCode','customers'));
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
            'sales_order_id' => ['required','not_in:0'],
            'dp' => ['numeric','not_in:0','lte:total'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'customer_id.not_in' => 'Pelanggan harus dipilih !',
            'sales_order_id.not_in' => 'Kode SO harus dipilih !',
            'dp.lte' => 'DP tidak bole melebihi total !',
            'dp.not_in' => 'DP tidak bole 0 !',
        ]);
        InitialPaymentSales::create($request->all());
        return redirect('/initial-payment-sales')->with('status','Data DP Berhasil Disimpan !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InitialPaymentSales  $initialPaymentSales
     * @return \Illuminate\Http\Response
     */
    public function show(InitialPaymentSales $initialPaymentSale)
    {
        return view('sales.initial-payment-sales.show',compact('initialPaymentSale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InitialPaymentSales  $initialPaymentSales
     * @return \Illuminate\Http\Response
     */
    public function edit(InitialPaymentSales $initialPaymentSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InitialPaymentSales  $initialPaymentSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InitialPaymentSales $initialPaymentSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InitialPaymentSales  $initialPaymentSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(InitialPaymentSales $initialPaymentSales)
    {
        InitialPaymentSales::destroy($initialPaymentSales->id);
        return redirect('/initial-payment-sales')->with('status','Data DP Berhasil Dihapus !');
    }

    public function getListSOCustomer(Request $request){
        if($request->ajax()){
            $inits = InitialPaymentSales::where('customer_id',$request->id)->pluck('sales_order_id');
            $salesOrders = SalesOrder::where('customer_id',$request->id)->where('status',1)->whereNotIn('id',$inits)->orderBy('id')->get();
            return compact('salesOrders');
        }
    }

    public function getSalesOrder(Request $request){
        if($request->ajax()){
            $salesOrder = SalesOrder::find($request->id);
            return response()->json($salesOrder);
        }
    }
}
