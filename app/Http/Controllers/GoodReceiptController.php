<?php

namespace App\Http\Controllers;

use App\GoodReceipt;
use App\PurchaseOrder;
use App\Supplier;
use Illuminate\Http\Request;

class GoodReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.good-receipt.index',  ['goodReceipts'=>GoodReceipt::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = GoodReceipt::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='BPB-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $suppliers=Supplier::all();
        return view('purchasing.good-receipt.create', compact('generatedCode','suppliers'));
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
            'quantities.*' => ['lte:qtyPO.*']
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'supplier_id.not_in' => 'Supplier harus dipilih !',
            'purchase_order_id.not_in' => 'Kode PO harus dipilih !',
            'quantities.*.lte' => 'Qty tidak bole melebihi Qty PO !',
        ]);
        $goodReceipt = GoodReceipt::create($request->all());
        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $goodReceipt->goodReceiptDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }
        PurchaseOrder::where('id',$request->input('purchase_order_id'))->update(['status'=>3]);
        return redirect('/good-receipt')->with('status','Data BPB Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GoodReceipt  $goodReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(GoodReceipt $goodReceipt)
    {
        return view('purchasing.good-receipt.show',compact('goodReceipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodReceipt  $goodReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodReceipt $goodReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodReceipt  $goodReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodReceipt $goodReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodReceipt  $goodReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodReceipt $goodReceipt)
    {
        //
    }
}
