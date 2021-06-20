<?php

namespace App\Http\Controllers;

use App\InitialPayment;
use App\PurchaseOrder;
use App\Supplier;
use Illuminate\Http\Request;

class InitialPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.initial-payment.index',  ['initialPayments'=>InitialPayment::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = InitialPayment::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='DP-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $suppliers=Supplier::all();
        return view('purchasing.initial-payment.create', compact('generatedCode','suppliers'));
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
            'supplier_id' => ['required','not_in:0'],
            'purchase_order_id' => ['required','not_in:0'],
            'dp' => ['numeric','not_in:0','lte:total'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'supplier_id.not_in' => 'Supplier harus dipilih !',
            'purchase_order_id.not_in' => 'Kode PO harus dipilih !',
            'dp.lte' => 'DP tidak bole melebihi total !',
            'dp.not_in' => 'DP tidak bole 0 !',
        ]);
        InitialPayment::create($request->all());
        return redirect('/initial-payment')->with('status','Data DP Berhasil Disimpan !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InitialPayment  $initialPayment
     * @return \Illuminate\Http\Response
     */
    public function show(InitialPayment $initialPayment)
    {
        return view('purchasing.initial-payment.show',compact('initialPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InitialPayment  $initialPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(InitialPayment $initialPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InitialPayment  $initialPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InitialPayment $initialPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InitialPayment  $initialPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InitialPayment $initialPayment)
    {
        InitialPayment::destroy($initialPayment->id);
        return redirect('/initial-payment')->with('status','Data DP Berhasil Dihapus !');
    }

    public function getListPOSupplier(Request $request){
        if($request->ajax()){
            $inits = InitialPayment::where('supplier_id',$request->id)->pluck('purchase_order_id');
            $purchaseOrders = PurchaseOrder::where('supplier_id',$request->id)->where('status',1)->whereNotIn('id',$inits)->orderBy('id')->get();
            return compact('purchaseOrders');
        }
    }

    public function getPurchaseOrder(Request $request){
        if($request->ajax()){
            $purchaseOrder = PurchaseOrder::find($request->id);
            return response()->json($purchaseOrder);
        }
    }
}
