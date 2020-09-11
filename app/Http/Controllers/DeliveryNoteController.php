<?php

namespace App\Http\Controllers;

use App\DeliveryNote;
use App\DeliveryRequestDetail;
use App\DeliveryRequest;
use App\Uom;
use Illuminate\Http\Request;

class DeliveryNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stock.delivery-note.index',  ['deliveryNotes'=>DeliveryNote::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = DeliveryNote::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='DN-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $deliveryRequests = DeliveryRequest::where('status',1)->get();
        $uoms =Uom::all();
        return view('stock.delivery-note.create', compact('deliveryRequests','uoms','generatedCode'));
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
            'delivery_request_id' => ['required','not_in:0'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'delivery_request_id.not_in' => 'Permintaan Pengiriman harus dipilih !',
        ]);

        $deliveryNote = DeliveryNote::create($request->all());

        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $deliveryNote->deliveryNoteDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }

        DeliveryRequest::where('id',$request->input('delivery_request_id'))->update(['status'=>2]);

        return redirect('/delivery-note')->with('status','Data Pengiriman Bahan Baku Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeliveryNote  $deliveryNote
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryNote $deliveryNote)
    {
        return view('stock.delivery-note.show', compact('deliveryNote'));
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


    public function getDeliveryRequest(Request $request){
        if($request->ajax()){
            $deliveryRequest = DeliveryRequest::find($request->id);
            return response()->json($deliveryRequest);
        }
    }
}
