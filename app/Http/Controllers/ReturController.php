<?php

namespace App\Http\Controllers;

use App\Retur;
use App\GoodReceipt;
use App\Supplier;
use Illuminate\Http\Request;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.retur.index',  ['returs'=>Retur::paginate(10)]);
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
        $generatedCode='RTR-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $suppliers=Supplier::all();
        return view('purchasing.retur.create', compact('generatedCode','suppliers'));
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
            'quantities.*' => ['lte:qtyBPB.*']
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'supplier_id.not_in' => 'Supplier harus dipilih !',
            'good_receipt_id.not_in' => 'Kode BPB harus dipilih !',
            'quantities.*.lte' => 'Qty tidak bole melebihi Qty BPB !',
        ]);
        $retur = Retur::create($request->all());
        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $retur->returDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }
        GoodReceipt::where('id',$request->input('good_receipt_id'))->update(['status'=>2]);
        return redirect('/retur')->with('status','Data Retur Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function show(Retur $retur)
    {
        return view('purchasing.retur.show',compact('retur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function edit(Retur $retur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retur $retur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retur $retur)
    {
        //
    }

    public function getListBPBSupplier(Request $request){
        if($request->ajax()){
            $goodReceipts = GoodReceipt::where('supplier_id',$request->id)->where('status',1)->orderBy('id')->get();
            return compact('goodReceipts');
        }
    }

    public function getGoodReceipt(Request $request){
        if($request->ajax()){
            $goodReceipt = GoodReceipt::find($request->id);
            return response()->json($goodReceipt);
        }
    }
}
