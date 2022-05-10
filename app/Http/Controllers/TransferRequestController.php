<?php

namespace App\Http\Controllers;

use App\TransferRequest;
use Illuminate\Http\Request;
use App\Uom;

class TransferRequestController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stock.transfer-request.index',  ['transferRequests'=>TransferRequest::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = TransferRequest::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='TR-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $transferRequests = TransferRequest::where('status',1)->get();
        $uoms =Uom::all();
        return view('stock.transfer-request.create', compact('transferRequests','uoms','generatedCode'));
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
            'delivery_date' => ['required'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'delivery_date.required' => 'Tanggal harus diisi !',
        ]);

        $TransferRequest = TransferRequest::create($request->all());

        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $TransferRequest->transferRequestDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }


        return redirect('/transfer-request')->with('status','Data Permintaan Kirim Barang Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransferRequest  $TransferRequest
     * @return \Illuminate\Http\Response
     */
    public function show(TransferRequest $transferRequest)
    {
        return view('stock.transfer-request.show', compact('transferRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransferRequest  $TransferRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(TransferRequest $transferRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransferRequest  $TransferRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransferRequest $transferRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransferRequest  $TransferRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferRequest $TransferRequest)
    {
        //
    }


    public function getTransferRequest(Request $request){
        if($request->ajax()){
            $transferRequest = TransferRequest::find($request->id);
            return response()->json($transferRequest);
        }
    }

    public function updateStatus(TransferRequest $transferRequest){
        TransferRequest::where('id',$transferRequest->id)->update(['status'=>3]);
        return redirect('/transfer-request')->with('status','Permintaan Kirim Barang Berhasil dibatalkan !');
    }
}
