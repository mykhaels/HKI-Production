<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Supplier;
use App\GoodReceipt;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.invoice.index',  ['invoices'=>Invoice::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = Invoice::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='IN-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $suppliers=Supplier::all();
        return view('purchasing.invoice.create', compact('generatedCode','suppliers'));
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
            'good_receipt_id' => ['required','not_in:0'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'supplier_id.not_in' => 'Supplier harus dipilih !',
            'good_receipt_id.not_in' => 'Kode BPB harus dipilih !',
        ]);

        $invoice = Invoice::create($request->all());

        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        $prices = $request->input('prices', []);
        $discounts = $request->input('discounts', []);
        $taxs = $request->input('taxs', []);
        $totals = $request->input('totals', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $invoice->invoiceDetails()->create(
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
        GoodReceipt::where('id',$request->input('good_receipt_id'))->update(['status'=>3]);
        return redirect('/invoice')->with('status','Data Faktur Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('purchasing.invoice.show',compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function getListBPBSupplier(Request $request){
        if($request->ajax()){
            $goodReceipts = GoodReceipt::where('supplier_id',$request->id)->where('status','<>','3')->orderBy('id')->get();
            return compact('goodReceipts');
        }
    }

    public function getGoodReceiptPO(Request $request){
        if($request->ajax()){
            $goodReceipt = GoodReceipt::find($request->id);
            if($goodReceipt->retur!=null){
                foreach($goodReceipt->goodReceiptDetails as $gd){
                    foreach($goodReceipt->retur->returDetails as $rt){
                        if($gd->product->id==$rt->product->id){
                            $gd->qty = $gd->qty-$rt->qty;
                        }
                    }
                }
            }

             return response()->json($goodReceipt);
         }
    }

    public function updateStatus(Invoice $invoice){
        Invoice::where('id',$invoice->id)->update(['status'=>3]);
        return redirect('/invoice')->with('status','Faktur Berhasil dibatalkan !');
    }
}
