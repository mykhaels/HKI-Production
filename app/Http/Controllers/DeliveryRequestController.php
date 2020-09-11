<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductionOrder;
use App\Uom;
use App\DeliveryRequest;

class DeliveryRequestController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('production.delivery-request.index',  ['deliveryRequests'=>DeliveryRequest::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = DeliveryRequest::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='DR-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $uoms = Uom::all();
        $productionOrders=ProductionOrder::where('status','=',1)->get();
        return view('production.delivery-request.create', compact('productionOrders','uoms','generatedCode'));
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
            'production_order_id' => ['required','not_in:0'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'production_order_id.not_in' => 'Perintah Produksi harus dipilih !',
        ]);

        $deliveryRequest = DeliveryRequest::create($request->all());

        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $deliveryRequest->deliveryRequestDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }

        ProductionOrder::where('id',$request->input('production_order_id'))->update(['status'=>2]);

        return redirect('/delivery-request')->with('status','Data Permintaan Bahan Baku Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryRequest $deliveryRequest)
    {
        return view('production.delivery-request.show',compact('deliveryRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryNote $deliveryNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryNote $deliveryNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryNote $deliveryNote)
    {
        //
    }
}
