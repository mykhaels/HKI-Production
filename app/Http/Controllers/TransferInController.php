<?php

namespace App\Http\Controllers;

use App\TransferIn;
use App\TransferRequest;
use Illuminate\Http\Request;

class TransferInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stock.transfer-in.index',  ['transferIns'=>TransferIn::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = TransferIn::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='TI-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $transferRequests=TransferRequest::where('status','1')->orderBy('id')->get();
        return view('stock.transfer-in.create', compact('generatedCode','transferRequests'));
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
            'transfer_request_id' => ['required','not_in:0'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'transfer_request_id.required' => 'Kode Permintaan harus dipilih !',
            'transfer_request_id.not_in' => 'Kode Permintaan harus dipilih !',
        ]);

        $transferIn = transferIn::create($request->all());
        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $transferIn->transferInDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }

        TransferRequest::where('id',$request->input('transfer_request_id'))->update(['status'=>2]);
        return redirect('/transfer-in')->with('status','Data Penerimaan Transfer Barang Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransferIn  $transferIn
     * @return \Illuminate\Http\Response
     */
    public function show(TransferIn $transferIn)
    {
        return view('stock.transfer-in.show',compact('transferIn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransferIn  $transferIn
     * @return \Illuminate\Http\Response
     */
    public function edit(TransferIn $transferIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransferIn  $transferIn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransferIn $transferIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransferIn  $transferIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferIn $transferIn)
    {
        //
    }

    public function getTransferRequest(Request $request){
        if($request->ajax()){
            $transferRequest = TransferRequest::where('id',$request->id)->where('status','<>','3')->orderBy('id')->first();
            return response()->json($transferRequest);
        }
    }

    public function updateStatus(TransferIn $transferIn){
        TransferIn::where('id',$transferIn->id)->update(['status'=>3]);
        return redirect('/transfer-in')->with('status','Penerimaan Berhasil dibatalkan !');
    }
}
