<?php

namespace App\Http\Controllers;

use App\SalesDeliveryNote;
use App\SalesOrder;
use App\Customer;
use Illuminate\Http\Request;

class SalesDeliveryNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.sales-delivery-note.index',  ['salesDeliveryNotes'=>SalesDeliveryNote::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = SalesDeliveryNote::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='SJ-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $customers=Customer::all();
        return view('sales.sales-delivery-note.create', compact('generatedCode','customers'));
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
            'quantities.*' => ['lte:qtySO.*']
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'customer_id.not_in' => 'Customer harus dipilih !',
            'sales_order_id.not_in' => 'Kode SO harus dipilih !',
            'quantities.*.lte' => 'Qty tidak bole melebihi Qty SO !',
        ]);
        $salesDeliveryNote = SalesDeliveryNote::create($request->all());
        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $salesDeliveryNote->salesDeliveryNoteDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }
        SalesOrder::where('id',$request->input('sales_order_id'))->update(['status'=>3]);
        return redirect('/sales-delivery-note')->with('status','Data SJ Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesDeliveryNote  $salesDeliveryNote
     * @return \Illuminate\Http\Response
     */
    public function show(SalesDeliveryNote $salesDeliveryNote)
    {
        return view('sales.sales-delivery-note.show',compact('salesDeliveryNote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesDeliveryNote  $salesDeliveryNote
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesDeliveryNote $salesDeliveryNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesDeliveryNote  $salesDeliveryNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesDeliveryNote $salesDeliveryNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesDeliveryNote  $salesDeliveryNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesDeliveryNote $salesDeliveryNote)
    {
        //
    }

    public function getListSOCustomer(Request $request){
        if($request->ajax()){
            $salesOrders = SalesOrder::where('customer_id',$request->id)->where('status',1)->orderBy('id')->get();
            return compact('salesOrders');
        }
    }
}
