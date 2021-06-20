<?php

namespace App\Http\Controllers;

use App\PurchaseOrder;
use App\Uom;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.purchase-order.index',  ['purchaseOrders'=>PurchaseOrder::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = PurchaseOrder::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='PO-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $suppliers=Supplier::all();
        $uoms =Uom::all();
        return view('purchasing.purchase-order.create', compact('generatedCode','uoms','suppliers'));
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
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'supplier_id.not_in' => 'Supplier harus dipilih !',
        ]);

        $PurchaseOrder = PurchaseOrder::create($request->all());

        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        $prices = $request->input('prices', []);
        $discounts = $request->input('discounts', []);
        $taxs = $request->input('taxs', []);
        $totals = $request->input('totals', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $PurchaseOrder->purchaseOrderDetails()->create(
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
        return redirect('/purchase-order')->with('status','Data Pembelian Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrder  $PurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        return view('purchasing.purchase-order.show',compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrder  $PurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $PurchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseOrder  $PurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $PurchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseOrder  $PurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $PurchaseOrder)
    {
        //
    }

    public function updateStatus(PurchaseOrder $purchaseOrder){
        PurchaseOrder::where('id',$purchaseOrder->id)->update(['status'=>2]);
        return redirect('/purchase-order')->with('status','PO Berhasil dibatalkan !');
    }



    public function getPrice(Request $request){
        $price = DB::table('product_uom')->where('product_id', $request->productId)->where('uom_id', $request->uomId)->pluck('price')->first();
        return $price;
    }

}
